<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Origin extends Model
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
        return $this->belongsToMany(Admin::class)->where('admin_type','vendor');
    }
}