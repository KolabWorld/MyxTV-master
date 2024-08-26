<?php
namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserWallet extends Model
{
    use SoftDeletes;

    protected $table = 'user_wallets';
    
    protected $fillable = [
        'user_id', 
        'wxrk_earned', 
        'wxrk_spent', 
        'wxrk_balance', 
        'watch_time', 
        'status'
    ];
    
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
    */
    protected $hidden = [
        'deleted_at',
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }
}
