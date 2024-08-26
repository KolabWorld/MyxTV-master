<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BlogCategory extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name', 
        'alias', 
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
        return $this->belongsTo(Admin::class);
    }

    public function updatedBy(){
        return $this->belongsTo(Admin::class);
    }

}

