<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model 
{

    protected $table = 'posts';
    public $timestamps = true;
    protected $fillable = array('title', 'image', 'body');

    public function include()
    {
        return $this->belongsTo('Client');
    }

    public function include()
    {
        return $this->belongsTo('Categories');
    }

}