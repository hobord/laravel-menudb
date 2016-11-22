<?php

namespace Hobord\MenuDb\Http\Middleware;

use Closure;
use Hobord\MenuDb\Menu as MenuDB;
use Menu;
use Auth;
use Cache;
use Session;


Use Illuminate\Support\Facades\App;

class MenuDbMiddleware
{

    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string  $role
     * @return mixed
     */
    public function handle($request, Closure $next)
    {

        $cached_menu = unserialize(Session::get('hobord_menu'));

        if( !Auth::check() ) {
            $cached_menu = unserialize(Cache::get('hobord_menu'));
        }
        elseif( $cached_menu == null ) {
            $this->makeMenus();
            return $next($request);
        }

        if( $cached_menu != null ) {
            $app = App::getFacadeApplication();
            $app->instance('menu',null);
            $app['menu'] = $cached_menu;
            return $next($request);
        }

        $this->makeMenus();

        return $next($request);
    }

    public function makeMenus()
    {
        $menu_records = MenuDB::with('items')->get();

        foreach ($menu_records as $menu_record) {
            $menu = Menu::make($menu_record->machine_name,function($menu){});

            $items = $menu_record->items->filter(function ($value, $key) {
                return $value->parent_id == null;
            })->sortBy('weight');

            $this->addItems($menu, $items, $menu_record->items->sortBy('weight'));
        }

        $app = App::getFacadeApplication();

        if(Auth::check()) {
            Session::set('hobord_menu',  serialize($app['menu']));
        }
        else {
            Cache::forever('hobord_menu', serialize($app['menu']));
        }
    }

    private function addItems($to, $items, $all_items)
    {
        $user = Auth::user();

        foreach ($items as $item) {
            $sub_items = [];

            foreach ($all_items as $key => $it) {
                if($it->parent_id == $item->id) {
                    $sub_items[] = $it;
                    unset($all_items[$key]);
                }
            }

            $can_access = true;
            if( is_array($item->meta_data) && array_key_exists('permission',$item->meta_data) ) {
                if(!$user || !$user->can($item->meta_data['permission'])) {
                    $can_access = false;
                }
            }

            if($can_access) {
                $new_item = $to->add($item->menu_text, $item->parameters)->nickname($item->unique_name);
                $new_item->data($item->meta_data);
                $this->addItems($new_item, $sub_items, $all_items);
            }
        }
    }
}