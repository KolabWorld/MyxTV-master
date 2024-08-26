<?php
namespace App\Http\Controllers\Frontend;

use DB;
use View;
use Auth;
use Session;
use stdClass;
use Datatables;
use Carbon\Carbon;

use App\User;
use App\Models\Admin;
use App\Models\Event;
use App\Models\Country;
use App\Models\Sponser;
use App\Models\EventType;
use App\Models\EventSponser;
use App\Models\EventParticipation;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\AdminController;

use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use App\Lib\Validation\Event as EventValidator;
use Illuminate\Validation\Rule;

use App\Helpers\GeneralHelper;
use App\Helpers\ConstantHelper;

class EventController extends AdminController
{
	public function __construct()
	{
		parent::__construct();
	}

	public function index(Request $request)
	{
		$user = \Auth::user();

		if($user->subscription_plan_id && ($user->is_payment_done == 0 || @$user->adminSubscriptionPlan->plan_expires_at <= date('Y-m-d H:i:s'))){
			return redirect('/subscription-plan-payment')->with(['warning' => 'Your Payment is pending for active plan']);
		}

        $countries = Country::get();
		$events = Event::with(
            [
                'eventType',
				'countries',
				'users', 
            ]
        )
        ->orderBy('start_date_time');

		if(!$user->hasRole('admin')){
			$events->where('created_by',$user->id);
		}

		if($request->status){
			$events->where('status', $request->status);
		}

		if($request->type){
			$events->where('type', '=', $request->type);
		}

        if($request->name){
			$events->where('name', '=', $request->name);
		}

		$events = $events->paginate(10);
		
		return view('frontend.event.index', array(
            'user' => $user,
			'tab' =>'events',
            'events' => $events,
            'request' => $request,
            'countries' => $countries,
		));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create(Request $request)
	{
		$user = \Auth::user();

		if($user->subscription_plan_id && ($user->is_payment_done == 0 || @$user->adminSubscriptionPlan->plan_expires_at <= date('Y-m-d H:i:s'))){
			return redirect('/subscription-plan-payment')->with(['warning' => 'Your Payment is pending for active plan']);
		}

		$event = new Event();
        $sponsers = Sponser::get();
        $countries = Country::get();
        $eventTypes = EventType::get();

		$action = '/event/create';

		$maxAllowedImages = @$user->subscriptionPlan->planName ? $user->subscriptionPlan->planName->max_images_allowed : 0;

		return view('frontend.event.create_edit', array(
			'tab' =>'events',
            'event' => $event,
            'action' => $action,
            'request' => $request,
            'sponsers' => $sponsers,
            'countries' => $countries,
            'eventTypes' => $eventTypes,
            'maxAllowedImages' => $maxAllowedImages,
		));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(Request $request)
	{ 
		$user = \Auth::user();
		
		$validator = (new EventValidator($request))->store();
		if ($validator->fails()) {
			throw new ValidationException($validator);
		}
		
		$event = new Event();
		$event->fill($request->all());
		$event->start_date_time = date('Y-m-d H:i', strtotime($request->start_date_time));
		$event->end_date_time = date('Y-m-d H:i', strtotime($request->end_date_time));
		$event->created_by = $user->id;
		$event->save();

        $event->countries()->sync($request->countries);

        if ($request->hasFile('company_logo')) {
            $event->addMediaFromRequest('company_logo')->toMediaCollection('company_logo');
        }

		if ($request->hasFile('thumbnail_image')) {
            $event->addMediaFromRequest('thumbnail_image')->toMediaCollection('thumbnail_image');
        }

        if ($request->hasFile('banners')) {
            foreach ($request->banners as $key => $image) {
                $event->addMediaFromRequest("banners[$key]")->toMediaCollection('banners');
            }
        }

		if ($request->hasFile('sponsers')) {
            foreach ($request->sponsers as $key => $image) {
                $event->addMediaFromRequest("sponsers[$key]")->toMediaCollection('sponsers');
            }
        }

		return [
			'message' => 'Event Added Succesfully!!!'
		];
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param $user
	 * @return Response
	 */
	public function edit($id)
	{
		$user = \Auth::user();

		if($user->subscription_plan_id && ($user->is_payment_done == 0 || @$user->adminSubscriptionPlan->plan_expires_at <= date('Y-m-d H:i:s'))){
			return redirect('/subscription-plan-payment')->with(['warning' => 'Your Payment is pending for active plan']);
		}

		$event = Event::with(
            [
                'eventType',
				'countries',
				'users', 
            ]
        )
		->find($id);
	
		if(!$user->hasRole('admin') && $event->created_by != $user->id){
			return redirect('/dashboard')->with("Record doesn't belong to you");
		}	

        $sponsers = Sponser::get();
        $countries = Country::get();
        $eventTypes = EventType::get();

		$event->banners = $event->getBanners();
		$event->sponsers = $event->getSponsers();
        $action = '/event/'.$id.'/edit';

		$maxAllowedImages = @$user->subscriptionPlan->planName ? $user->subscriptionPlan->planName->max_images_allowed : 0;
		$maxAllowedImages -= count($event->banners);
		
		return view('frontend.event.create_edit', array(
			'tab' =>'events',
            'event' => $event,
            'action' => $action,
            'sponsers' => $sponsers,
            'countries' => $countries,
            'eventTypes' => $eventTypes,
            'maxAllowedImages' => $maxAllowedImages,
		));	
	}

	public function update(Request $request,$id)
	{ 
		$user = \Auth::user();

		$validator = (new EventValidator($request))->update();
		if ($validator->fails()) {
			throw new ValidationException($validator);
		}
		
		$event = Event::find($id);
		$event->fill($request->all());
		$event->updated_by = $user->id;
		$event->save();

        $event->countries()->sync($request->countries);

        if ($request->hasFile('company_logo')) {
            $event->addMediaFromRequest('company_logo')->toMediaCollection('company_logo');
        }

		if ($request->hasFile('thumbnail_image')) {
            $event->addMediaFromRequest('thumbnail_image')->toMediaCollection('thumbnail_image');
        }

        if ($request->hasFile('banners')) {
            foreach ($request->banners as $key => $image) {
                $event->addMediaFromRequest("banners[$key]")->toMediaCollection('banners');
            }
        }

		if ($request->hasFile('sponsers')) {
            foreach ($request->sponsers as $key => $image) {
                $event->addMediaFromRequest("sponsers[$key]")->toMediaCollection('sponsers');
            }
        }

		return [
			'message' => 'Event Updated Succesfully!!!'
		];
	}

	public function destroy($id){
		$user = \Auth::user();

		$event = Event::find($id);
		if(!$event){
			return [
				'message' => 'Event doest not exist.',
			];
		}
		else{
			// $event->sponsers()->detach();
			$event->delete();
		}

		return [
			'message' => 'Record deleted successfully!',
		];
	}
}