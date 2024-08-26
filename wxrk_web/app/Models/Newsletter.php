<?php

namespace App\Models;

use App\Helpers\ConstantHelper;
use App\User;
use Illuminate\Database\Eloquent\Model;

class Newsletter extends Model
{

    protected $table = 'newsletter';

    protected $fillable = [
        'email',
        'status'
        
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var arraysequence
     */
    protected $hidden = [
        'deleted_at'
    ];

    
}