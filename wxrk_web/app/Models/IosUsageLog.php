<?php
namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class IosUsageLog extends Model
{
    use SoftDeletes;
    
    protected $fillable = [
        'user_id', 
        'event_name', 
        'log_date', 
        'event_time', 
        'current_time', 
        'idle_time', 
        'total_idle_time', 
        'timer_status'
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
