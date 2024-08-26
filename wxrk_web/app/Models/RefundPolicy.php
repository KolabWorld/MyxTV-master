<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RefundPolicy extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name', 
        'description', 
        'description_1', 
        'status',
        'admin_id', 
        'designer_id', 
        'user_id', 
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var arraysequence
     */
    protected $hidden = ['deleted_at'];

    public function admin() {
        return $this->belongsTo(Admin::class);
    }

    public function designer() {
        return $this->belongsTo(Designer::class);
    }

    public function user() {
        return $this->belongsTo(User::class);
    }

}
