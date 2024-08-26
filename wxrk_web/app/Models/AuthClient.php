<?php

namespace App\Models;

class AuthClient extends BaseModel
{

    protected $table = 'auth_clients';

    protected $fillable = [
        'id', 'name', 'secret'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var arraysequence
     */

}
