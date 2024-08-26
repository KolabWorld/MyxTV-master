<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Smtpdetail extends Model
{


    protected $table = 'smtpdetails';

    protected $fillable = [
        'host',
		'username', 
		'password', 
		'secure',
		'port',
        'created_by', 
        'updated_by', 
        'created_at', 
        'updated_at'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var arraysequence
     */

    public function createdBy(){
        return $this->belongsTo(User::class);
    }

    public function updatedBy(){
        return $this->belongsTo(User::class);
    }

}
