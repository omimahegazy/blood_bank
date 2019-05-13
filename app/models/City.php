<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class City extends Model 
{

    protected $table = 'cites';
    public $timestamps = true;
    protected $fillable = array('name', 'governorate_id');

    public function contain()
    {
        return $this->hasMany('Client');
    }

}