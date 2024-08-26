<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdminOrigin extends Model
{

    protected $table = 'admin_origin';

    protected $fillable = [
        'admin_id', 
        'origin_id', 
        'created_at', 
        'updated_at'
    ];

    public function admin()
    {
        return $this->belongsTo(Admin::class);
    }

    public function origin()
    {
        return $this->belongsTo(Origin::class);
    }

}
