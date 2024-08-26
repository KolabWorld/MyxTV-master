<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BusinessCategory extends Model
{

    protected $fillable = [
        'name',
        'status',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var arraysequence
     */
    protected $hidden = [
        'deleted_at'
    ];
    
    public function vendors()
    {
        return $this->hasMany(Admin::class)->where('admin_type','vendor');
    }
}