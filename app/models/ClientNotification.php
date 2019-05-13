<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ClientNotification extends Model 
{

    protected $table = 'client_notifications';
    public $timestamps = true;
    protected $fillable = array('client_id', 'notification_id');

}