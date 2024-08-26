<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Query extends Model
{

    use SoftDeletes;

    protected $table = 'queries';

    protected $fillable = [
        'name', 
        'email', 
        'mobile', 
        'subject', 
        'message', 
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
