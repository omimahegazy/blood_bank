<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model 
{

    protected $table = 'notifications';
    public $timestamps = true;
    protected $fillable = array('donation_request_id');

    public function include()
    {
        return $this->belongsToMany('Client');
    }

}