<?php
namespace App\Http\Controllers\API;

use App\User;
use App\Models\Event;
use App\Models\EventUser;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Exceptions\ApiGenericException;

use Illuminate\Validation\ValidationException;
use App\Lib\Validation\Master as Validator;


class EventController extends Controller
{

    const QUEUE_NAME = 'API';

    public function __construct()
    {
        parent::__construct();
    }

    public function index(Request $request)
    {
        $user = \Auth::user();
        
        $this->validate($request, [
            'from_date' => [
                'nullable', 'date',
            ],
            'to_date' => [
                'nullable', 'date', 'after_or_equal:from_date'
            ]
        ],[
            'to_date.after_or_equal' => 'Please select Proper Date Range'
        ]);

        $events = Event::with(
            [
                'eventType',
                'countries',
            ]
        )
        ->whereDate('end_date_time','>=',date('Y-m-d H:i:s'))
        ->where('status','=', 'active')
        ->orderBy('start_date_time');

        if($request->type){
			$events->where('type', '=', $request->type);
		}

        if($request->name){
			$events->where('name', '=', $request->name);
		}

        if($request->from_date){
            $events->whereDate('start_date_time',">=",date('Y-m-d',strtotime($request->from_date)));
        }
        if($request->to_date){
            $events->whereDate('end_date_time',"<=",date('Y-m-d',strtotime($request->to_date)));
        }

        $events = $events->get();

        // $events = $events->map(function($val, $key){
        //     $val->start_date_time = date('Y-m-d h:i:s A', strtotime($val->start_date_time));
        //     $val->end_date_time = date('Y-m-d h:i:s A', strtotime($val->end_date_time));

        //     return $val;
        // });

        $data = array(
            'events' => $events,
        );

        return array(
			'message' => __('message.fetch_records'),
			'data' => $data,
		);
    }

    public function show($id)
    {
        $user = \Auth::user();
        $event = Event::with([
            'countries', 
            'eventType', 
            'users', 
        ])->find($id);

        if(!$event){
            throw new ApiGenericException(__('message.record_not_found'));
        }
        
        if($event->end_date_time <= date('Y-m-d H:i:s')){
            throw new ApiGenericException(__('message.has_expired', ['static' => __('static.event')]));
        }

        // $event->start_date_time = date('Y-m-d h:i:s A', strtotime($event->start_date_time));
        // $event->end_date_time = date('Y-m-d h:i:s A', strtotime($event->end_date_time));
        
        $data = array(
            'event' => $event,
        );

        return array(
			'message' => __('message.fetch_records'),
			'data' => $data,
		);
    }

    public function joinEvent(Request $request){
        $user = \Auth::user();

        if($request->event_id && $request->user_id){
            $event = Event::find($request->event_id);
            $user = User::find($request->user_id);

            if(!$user){
                throw new ApiGenericException(__('message.doesnt_exist', ['static' => __('static.user')]));
            }
            elseif(!$event){
                throw new ApiGenericException(__('message.doesnt_exist', ['static' => __('static.event')]));
            }
            elseif($event && $event->end_date_time <= date('Y-m-d H:i:s')){
                throw new ApiGenericException(__('message.has_expired', ['static' => __('static.event')]));
            }
            else{
                $userEvent = EventUser::where('user_id', $user->id)
                    ->where('event_id', $event->id)
                    ->first();

                if($userEvent){
                    throw new ApiGenericException(__('message.already_joined'));
                }

                $events = $user->events()->pluck('events.id')->toArray();
                array_push($events,$event->id);
                
                $user->events()->sync($events);

                return array(
                    'message' => "Congratulations!, You have successfully enrolled.",
                    'data' => date('Y-m-d H:i:s')
                );
            }
        }
        else{
            throw new ApiGenericException(__('message.something_went_wrong'));
        }
    }
}