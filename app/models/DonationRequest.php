<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DonationRequest extends Model 
{

    protected $table = 'donation_requests';
    public $timestamps = true;
    protected $fillable = array('client_id');

    public function requests()
    {
        return $this->hasOne('Notification');
    }

    public function contain()
    {
        return $this->belongsTo('Client');
    }

    public function requests()
    {
        return $this->hasMany('BloodType');
    }

}