<?php
namespace App\Http\Controllers\API;

use View;
use Auth;
use Carbon\Carbon;

use App\User;
use App\Models\Role;
use App\Models\Admin;
use App\Models\AdminRole;
use App\Models\EquipmentDetail;
use App\Models\EquipmentDetailLog;
use App\Models\EquipmentTypeMaster;
use App\Models\ManufacturerMaster;
use App\Models\ThirdPartyCompanyMaster;
use App\Models\Notification;
use App\Models\NotificationAdminMapping;

use Illuminate\Http\Request;
use App\Helpers\GeneralHelper;
use App\Helpers\MenuHelper;
use App\Helpers\ConstantHelper;
use App\Exceptions\UserNotFound;
use App\Http\Controllers\Controller;
use App\Exceptions\ApiGenericException;
use App\Notifications\CommonNotification;
use App\Lib\Validation\Auth as Validator;
use Illuminate\Validation\ValidationException;
use \Laravel\Passport\Http\Controllers\AccessTokenController;

class NotificationController extends Controller
{

    const QUEUE_NAME = 'API';

    public function __construct()
    {
        parent::__construct();
    }

    public function index() {
        $auth = \Auth::user();
        $notifications = MenuHelper::adminNotifications();

        return array(
			'message' => __('message.fetch_records'),
			'data' => $notifications,
		);
    }

    public function markRead(Request $request) {
        $auth = \Auth::user();

        $notification = NotificationAdminMapping::where('notification_id',$request->notification_id)->where('admin_id',$request->admin_id)->first();
        if($notification){
            $notification->mark_as_read = 1;
            $notification->save();
    
            $notification = Notification::find($request->notification_id);
    
            $notification->load([
                'adminMappings'
            ]);
            
            return array(
                'message' => __('message.updated_successfully', ['static' => __('static.notification')]),
                'data' => $notification,
            );
        }
        else{
            return array(
                'message' => __('message.something_went_wrong'),
                'data' => null,
            );
		}
    }
}