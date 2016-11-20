<?php

namespace Hobord\MenuDb;

use Illuminate\Database\Eloquent\Model;
use Auth;
use Cache;
use Session;

class Menu extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'hobord_menus';

    protected $fillable = [
        'machine_name',
        'display_name',
        'description',
        'lang'
    ];

    public function items()
    {
        return $this->hasMany('Hobord\MenuDb\MenuItem');
    }

    static public function refresh()
    {
        Session::forget('hobord_menu');
        Cache::forget('hobord_menu');
    }

}