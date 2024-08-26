<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdminRole extends Model
{

    protected $table = 'admin_role';

    protected $fillable = [
        'admin_id', 
        'role_id', 
        'created_at', 
        'updated_at'
    ];

    public function admin()
    {
        return $this->belongsTo(Admin::class);
    }

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

}
