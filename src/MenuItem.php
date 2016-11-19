<?php

namespace Hobord\MenuDb;

use Illuminate\Database\Eloquent\Model;

class MenuItem extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'hobord_menu_items';

    protected $casts = [
        'parameters' => 'json',
        'meta_data' => 'json'
    ];

    protected $fillable = [
        'menu_id',
        'parent_id',
        'unique_name',
        'weight',
        'menu_text',
        'parameters',
        'divide',
        'meta_data'
    ];

    public function menu()
    {
        return $this->belongsTo('Hobord\MenuDb\Menu');
    }

    public function parent()
    {
        return $this->belongsTo('Hobord\MenuDb\MenuItem', 'parent_id', 'id');
    }

    public function setParentByUniqueName($name)
    {
        $parent = MenuItem::where('menu_id', $this->menu_id)->where('unique_name', $name)->first();
        if($parent) {
            $this->parent_id = $parent->id;
        }
    }
}