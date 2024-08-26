<?php

namespace App\Models;

class AuthAccessToken extends BaseModel
{

    protected $table = 'auth_access_tokens';

    protected $fillable = [
        'user_id', 
        'client_id', 
        'revoked', 
        'device_name', 
        'device_address', 
        'os_version', 
        'app_version', 
        'latitude', 
        'longitude',
        'created_at', 
        'updated_at', 
        'expires_at'
    ];


    /**
     * The attributes that should be hidden for arrays.
     *
     * @var arraysequence
     */

}
