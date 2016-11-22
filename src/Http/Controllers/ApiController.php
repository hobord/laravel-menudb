<?php


namespace Hobord\MenuDb\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Menu;

class ApiController extends Controller
{
    public function index($menu_name)
    {
        $menu = Menu::get($menu_name)->all();
        return $menu;
    }
}