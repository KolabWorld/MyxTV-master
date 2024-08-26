<?php
namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class WalletTransaction extends Model
{
    use SoftDeletes;

    protected $table = 'wallet_transactions';
    
    protected $fillable = [
        'offer_id', 
        'user_id', 
        'type', 
        'wxrk_balance', 
        'app_usage_time', 
        'idle_time', 
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

    public function offer() {
        return $this->belongsTo(Offer::class);
    }

}
