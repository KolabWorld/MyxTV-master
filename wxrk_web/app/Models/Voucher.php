<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Voucher extends Model
{

    use SoftDeletes;

    protected $fillable = [
        'code',
        'valid_from',
        'valid_to',
        'discount_type',
        'value',
        'max_uses',
        'used',
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
