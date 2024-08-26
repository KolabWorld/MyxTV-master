<?php
namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class IosIdleTime extends Model
{
    use SoftDeletes;
    
    protected $fillable = [
        'user_id', 
        'ios_usage_log_id', 
        'log_date', 
        'last_sync_time', 
        'current_time', 
        'start_time', 
        'end_time', 
        'idle_time', 
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

    public function iosUsageLog() {
        return $this->belongsTo(IosUsageLog::class);
    }

}
