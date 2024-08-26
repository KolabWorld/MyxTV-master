<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class StaticContent extends Model
{
	use SoftDeletes;

	protected $table = 'static_contents';
	
  	protected $fillable = [
		'name', 
		'page_type', 
		'description',
		'status',
	];

	protected $hidden = [
        'deleted_at'
    ];

}
