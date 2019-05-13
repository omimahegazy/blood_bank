<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Governorat extends Model 
{

    protected $table = 'governorates';
    public $timestamps = true;
    protected $fillable = array('name');

    public function include()
    {
        return $this->hasMany('City');
    }

    public function include()
    {
        return $this->belongsToMany('Client');
    }

}