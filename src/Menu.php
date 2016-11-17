<?php

namespace Hobord\MenuDb;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'hobord_menus';

    public function items()
    {
        return $this->hasMany('Hobord\MenuDb\MenuItem');
    }
}