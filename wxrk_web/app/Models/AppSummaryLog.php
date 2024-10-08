<?php
namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AppSummaryLog extends Model
{
    use SoftDeletes;
    
    protected $fillable = [
        'user_id', 
        'log_date', 
        'app_name', 
        'package_name', 
        'start_time', 
        'end_time', 
        'usage_time', 
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
