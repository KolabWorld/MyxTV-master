<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OauthAccessToken extends Model
{

    protected $fillable = [
        'device_name', 
        'device_address', 
        'os_version', 
        'app_version', 
        'firebase_id', 
        'latitude', 
        'longitude'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var arraysequence
     */
    public function client() {
        return $this->belongsTo(OauthClient::class);
    }
}