<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Categories extends Model 
{

    protected $table = 'categories';
    public $timestamps = true;
    protected $visible = array('name');

    public function include()
    {
        return $this->hasMany('Post');
    }

}