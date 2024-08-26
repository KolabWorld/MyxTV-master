<?php
namespace App\Models;

use App\User;
use App\Admin;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class NotificationAdminMapping extends Model
{
	use SoftDeletes;

    protected $fillable = [
        'notification_id', 
        'admin_id',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'deleted_at',
    ];

    public function notification() {
		return $this->belongsTo(Notification::class);
	}

    public function admin() {
		return $this->belongsTo(Admin::class);
	}

    public function timeago() {
        $timestamp = strtotime($this->created_at);	
        
        $strTime = array("second", "minute", "hour", "day", "month", "year");
        $length = array("60","60","24","30","12","10");
 
        $currentTime = date('Y-m-d H:i:s');
        if($currentTime >= $timestamp) {
             $diff = date('Y-m-d H:i:s')- $timestamp;
             dd($diff);
             for($i = 0; $diff >= $length[$i] && $i < count($length)-1; $i++) {
             $diff = $diff / $length[$i];
             }
 
             $diff = round($diff);
             return $diff . " " . $strTime[$i] . "(s) ago ";
        }
     }

}


