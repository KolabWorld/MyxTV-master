<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Contact extends Model
{

    use SoftDeletes;

	protected $table = 'contact_us';
	
  	protected $fillable = [
		'name', 
		'email',
        'mobile',
		'message',
        'status',

	];

	protected $hidden = [
        'deleted_at'
    ];

}
