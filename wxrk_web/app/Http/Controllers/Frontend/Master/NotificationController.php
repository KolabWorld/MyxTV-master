<?php
namespace App\Http\Controllers\Frontend\Master;

use App\Models\Notification;
use App\Models\NotificationAdminMapping;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Controllers\Controller;

class NotificationController extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index(Request $request)
    {
        $notifications = Notification::with(['admin','equipmentDetail'])->latest();

        if ($request->search) {
            $notifications->where('name', 'like', '%' . $request->search . '%');
        }

        $auth = \Auth::user();
        if(!($auth->hasRoles(['admin']))){
            return redirect('/dashboard');
        }

        $notifications = $notifications->paginate(10);

        return view('frontend.master.notification.index', [
            'records' => $notifications,
        ]);
    }
    
    public function view($id)
    {
        $notification = Notification::with(['admin','equipmentDetail'])->find($id);
       
        return view(
            'frontend.master.notification.create_edit',
            array(
                'notification' => $notification
            )
        );
    }

    public function markRead(Request $request) {
        $auth = \Auth::user();

        $notification = NotificationAdminMapping::where('notification_id',$request->notification_id)->where('admin_id',$auth->id)->first();
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