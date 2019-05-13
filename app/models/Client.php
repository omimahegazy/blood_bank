<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Client extends Model 
{

    protected $table = 'clients';
    public $timestamps = true;
    protected $fillable = array('id', 'name', 'phone', 'email', 'date_of_birth', 'password', 'is_active', 'last_donation', 'blood_type_id');

    public function requests()
    {
        return $this->hasMany('DonationRequest');
    }

    public function include()
    {
        return $this->belongsToMany('Notification');
    }

    public function include()
    {
        return $this->hasMany('Post');
    }

    public function contain()
    {
        return $this->belongsToMany('Governorat');
    }

    public function contain()
    {
        return $this->belongsToMany('BloodType');
    }

    public function requests()
    {
        return $this->hasMany('ContactUs');
    }

}