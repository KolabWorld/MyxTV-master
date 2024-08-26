<?php
namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DayWiseSummary extends Model
{
    use SoftDeletes;

    protected $table = 'day_wise_summary';
    
    protected $fillable = [
        'user_id', 
        'user_type', 
        'android_usage_log_id', 
        'app_summary_log_id', 
        'log_date', 
        'wxrk_per_minute', 
        'total_app_usage_time', 
        'day_total_time', 
        'day_idle_time', 
        'watch_time', 
        'time_saved', 
        'time_saved_percentage', 
        'wxrk_earned', 
        'wxrk_spent', 
        'wxrk_balance', 
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

    public function androidUsageLog() {
        return $this->belongsTo(androidUsageLog::class);
    }

    public function appSummaryLog() {
        return $this->belongsTo(AppSummaryLog::class);
    }

}
