<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdminDeviceToken extends Model
{

    protected $fillable = [
        'admin_id', 
        'client_secret', 
        'token'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
    */
    public function admin() {
        return $this->belongsTo(Admin::class);
    }
}
