<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PaymentChannel extends Model
{
    use SoftDeletes;

    protected $table = 'payment_channels';

    protected $fillable = [
        'name', 
        'alias', 
        'access_id', 
        'access_code', 
        'access_secret', 
        'status', 
        'created_at', 
        'updated_at'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var arraysequence
     */
    protected $hidden = ['deleted_at'];
}
