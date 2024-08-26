<?php

namespace App\Http\Controllers\API;

use Auth;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Exceptions\NotFoundException;
use App\Exceptions\ApiGenericException;

use Carbon\Carbon;
use App\Http\Requests\AttendanceRequest;
use App\Models\Attendance;
use App\Models\AttendanceSummary;
use App\Models\AttendanceRegularizationRequests;

/**
 * Handling all requests related to GTM tracking
 */
class AttendanceController extends Controller
{
    
    public function __construct(Request $request)
    {
        // 
    }

    public function store(AttendanceRequest $request) {

        try {
            $user = Auth::guard('api')->user();

            $attendance = new Attendance;
            $attendance->latitude = $request->latitude;
            $attendance->longitude = $request->longitude;
            $attendance->type = $request->type;
            $attendance->user_id = $user->id;

            $attendance->save();

            return $attendance;
            
        } catch (Exception $e) {
            throw new ApiGenericException("Could not update password, " . $e->getMessage());
        }
    }
    /**
     * store data in db for gtm tracking details
     * 
     * @param $request Request
     */
    public function attendanceToday()
    {
        // get user from api token
        $user = Auth::guard('api')->user();
        $date = Carbon::today()->toDateString();
        return Attendance::where('user_id', $user->id)
                    ->whereDate('created_at', $date)
                    ->orderBy('id', 'DESC')
                    ->get();
    }

    public function month($month = null) {

        if(!$month) {
            $month = date('Y-m');
        }
        $user = Auth::guard('api')->user();
        return AttendanceSummary::whereRaw("date LIKE '$month%'")
                    ->where('user_id', $user->id)
                    ->orderBy('date', 'DESC')
                    ->get();

    } 

    public function details($id)
    {
        // get user from api token
        $user = Auth::guard('api')->user();
        $attendance = AttendanceSummary::where('user_id', $user->id)
                    ->where('id', $id)
                    ->first();
        $tracks = null;
        if ($attendance) {
            $tracks = Attendance::where('user_id', $user->id)
                    ->whereDate('created_at', $attendance->date)
                    ->orderBy('id', 'DESC')
                    ->get();
        }

        return [
            'attendance' => $attendance,
            'tracks' => $tracks
        ];
    }

    public function postRegularize(Request $request, $id) {
        $user = Auth::guard('api')->user();

        $regularize = AttendanceRegularizationRequests::where('attendance_id','=', $id)
                        ->where('user_id', '=', $user->id)
                        ->orderBy('id', 'DESC')
                        ->first();

        if ($regularize) {
            if ($regularize->status == AttendanceRegularizationRequests::STATUS_APROVED) {
                throw new ApiGenericException("Regularization request already approved");
                
            }

            if ($regularize->status == AttendanceRegularizationRequests::STATUS_PENDING) {
                throw new ApiGenericException("Regularization request already sent");
                
            }
        }
        $regularize = new AttendanceRegularizationRequests;
        $regularize->attendance_id = $id;
        $regularize->user_id = $user->id;
        $regularize->remark = $request->remark;
        $regularize->save();

        return $regularize;
    }

    public function regularizeList($month = null) {
        if(!$month) {
            $month = date('Y-m');
        }
        $user = Auth::guard('api')->user();
        $requests = AttendanceRegularizationRequests::where('user_id', $user->id)
                        ->whereRaw("created_at LIKE '$month%'")
                        ->orderBy('id', 'DESC')
                        ->get();
        return $requests;
    }


}
