<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Settings extends Model 
{

    protected $table = 'settings';
    public $timestamps = true;
    protected $fillable = array('email', 'youtube_url');
    protected $visible = array('phone', 'facebook_url');

}