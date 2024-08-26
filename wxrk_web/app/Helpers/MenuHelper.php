<?php
namespace App\Helpers;

use DateTime;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

use App\Models\Admin;
use App\Models\Notification;
use App\Models\NotificationAdminMapping;

use App\Helpers\ConstantHelper;

class MenuHelper
{

    public static function statuses(){
        $auth = \Auth::user();
        
        $statuses = ConstantHelper::APPLICATION_STATUS;
        
        return $statuses;
      
    }

    public static function inspectionDue(){
        $auth = \Auth::user();        
        $inspectionDue = ConstantHelper::INSPECTION_DUE;        
        return $inspectionDue;
      
    }
    
    public static function expiryDocs(){
        $auth =\Auth::user();
        $expiryDocs = ConstantHelper::EXPIRY_DOCS;
        return $expiryDocs;
    }

    public static function obsStatus(){
        $auth =\Auth::user();
        $obsStatus = ConstantHelper::OBS_STATUS;
        return $obsStatus;
    }

    public static function adminNotifications(){
        $auth = \Auth::user();
         
        $notifications = Notification::with(['adminMappings','equipmentDetail'])->whereHas('adminMappings',function($query) use ($auth){
            $query->where('admin_id',$auth->id);
        })->latest()->get();

        return $notifications;
    }

    public static function adminActiveNotificationsCount(){
        $auth = \Auth::user();
         
        $count = Notification::with(['adminMappings'])->whereHas('adminMappings',function($query) use ($auth){
            $query->where('admin_id',$auth->id)
                ->where('mark_as_read',0);
        })->count();

        return $count;
    }

    public static function time_elapsed_string($datetime, $full = false) {
        $now = new DateTime;
        $ago = new DateTime($datetime);
        $diff = $now->diff($ago);
        $diff->w = floor($diff->d / 7);
        $diff->d -= $diff->w * 7;
        
        $string = array(
            'y' => 'year',
            'm' => 'month',
            'w' => 'week',
            'd' => 'day',
            'h' => 'hour',
            'i' => 'minute',
            's' => 'second',
        );
        foreach ($string as $k => &$v) {
            if ($diff->$k) {
                $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
            } else {
                unset($string[$k]);
            }
        }
    
        if (!$full) $string = array_slice($string, 0, 1);
        return $string ? implode(', ', $string) . ' ago' : 'just now';
    }
}