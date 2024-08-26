<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Blog extends Model
{

    use SoftDeletes;

    protected $table = 'blog';

    protected $fillable = [
        'title',
		'shortarticle', 
		'article', 
		'author', 
		'views', 
		'useful',
		'votes',
		'private', 
        'order',
		'parentid',
		'language',
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
    protected $hidden = ['deleted_at'];

    public function createdBy(){
        return $this->belongsTo(User::class);
    }

    public function updatedBy(){
        return $this->belongsTo(User::class);
    }

}
