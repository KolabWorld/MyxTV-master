<?php

namespace App\Http\Controllers\Frontend\Master;

use App\Models\DayWisePoolMaster;

use Illuminate\Http\Request;
use App\Http\Controllers\AdminController;

use Illuminate\Validation\ValidationException;
use App\Lib\Validation\Master as MasterValidator;
use App\Models\DayWiseSummary;
use App\Models\PoolMaster;
use App\User;

class DayWisePoolMasterController extends AdminController
{
	public function __construct()
	{
		parent::__construct();
	}

	public function index(Request $request)
	{
		$user = \Auth::user();

		$records = DayWisePoolMaster::latest();

		if ($request->status) {
			$records->where('status', $request->status);
		}

		$records = $records->paginate(10);

		return view('frontend.master.day-wise-pool-master.index', array(
			'tab' => 'day-wise-pool-master',
			'user' => $user,
			'records' => $records,
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

		$record = new DayWisePoolMaster();
		$action = '/day-wise-pool-master/create';

		return view('frontend.master.day-wise-pool-master.create_edit', array(
			'tab' => 'day-wise-pool-master',
			'request' => $request,
			'record' => $record,
			'action' => $action,
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

		$validator = (new MasterValidator($request))->storeDayWisePoolMaster();
		if ($validator->fails()) {
			throw new ValidationException($validator);
		}

		$poolMaster = PoolMaster::latest()->first();

		$record = new DayWisePoolMaster();
		$record->fill($request->all());
		$record->pool_master_id = $poolMaster->id;
		$record->save();

		return [
			'message' => 'Day Wise Pool Master Added Succesfully!!!'
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

		$record = DayWisePoolMaster::find($id);

		$action = '/day-wise-pool-master/' . $id . '/edit';

		return view('frontend.master.day-wise-pool-master.create_edit', array(
			'tab' => 'day-wise-pool-master',
			'record' => $record,
			'action' => $action,
		));
	}

	public function update(Request $request, $id)
	{
		$user = \Auth::user();

		$request->request->add(['id' => $id]);
		$validator = (new MasterValidator($request))->updateDayWisePoolMaster();
		if ($validator->fails()) {
			throw new ValidationException($validator);
		}

		$poolMaster = PoolMaster::latest()->first();

		$record = DayWisePoolMaster::find($id);
		$record->fill($request->all());
		$record->pool_master_id = $poolMaster->id;
		$record->save();

		return [
			'message' => 'Day Wise Pool Master Updated Succesfully!!!'
		];
	}

	public function destroy($id)
	{
		$user = \Auth::user();

		$record = DayWisePoolMaster::find($id);
		$record->delete();

		return [
			'message' => 'Record deleted successfully!',
		];
	}

	public function calculate()
	{
		try {
			$lastDate = date('Y-m-d', strtotime("-1 days"));
			$poolMaster = PoolMaster::first();
			$lastDayPoolMaster = DayWisePoolMaster::whereDate('created_at', '=', $lastDate)->first();
			if (!$lastDayPoolMaster) {
				$dayWisePoolMaster = new DayWisePoolMaster();
				$dayWisePoolMaster->pool_master_id = $poolMaster->id;
				$dayWisePoolMaster->pool_balance = $poolMaster->wxrk_pool;
				$dayWisePoolMaster->pool_date = date('Y-m-d');
				$dayWisePoolMaster->total_user = 100;
				$dayWisePoolMaster->save();

				$dayLimit = $dayWisePoolMaster->pool_balance * $poolMaster->daily_limit;
				$maxPerUser = $poolMaster->max_coin_per_user * $dayWisePoolMaster->total_user;
				$wxrkDistLimit = 0;
				if ($dayLimit > $maxPerUser) {
					$wxrkDistLimit = $maxPerUser;
				} else {
					$wxrkDistLimit = $dayLimit;
				}
				$wxrkPerUserPerDay = $wxrkDistLimit / $dayWisePoolMaster->total_user;
				$wxrkPerMin = $wxrkPerUserPerDay / (24 * 60);

				$dayWisePoolMaster->daily_limit = $dayLimit;
				$dayWisePoolMaster->wxrk_dist_limit = $wxrkDistLimit;
				$dayWisePoolMaster->wxrk_per_user_per_day = $wxrkPerUserPerDay;
				$dayWisePoolMaster->wxrk_per_min = $wxrkPerMin;
				$dayWisePoolMaster->status = 'active';
				$dayWisePoolMaster->save();
			} else {
				$totalUser = User::where('status', 'active')->count();
				$todaysPoolMaster = DayWisePoolMaster::whereDate('created_at', '=', date('Y-m-d'))->first();
				if ($todaysPoolMaster) {
					return back()->with('warning', "Pool Master Already exists for today.");
				}

				$lastDayWxrkEarned = DayWiseSummary::whereDate('created_at', '=', date('Y-m-d', strtotime("-1 day")))->sum('wxrk_earned');
				$lastDayWxrkSpent = DayWiseSummary::whereDate('created_at', '=', date('Y-m-d', strtotime("-1 day")))->sum('wxrk_spent');
				$lastDayPoolBalance = $lastDayPoolMaster->pool_balance;

				$wxrk_pool = $lastDayPoolBalance - $lastDayWxrkEarned + $lastDayWxrkSpent;


				$dayWisePoolMaster = new DayWisePoolMaster();
				$dayWisePoolMaster->pool_master_id = $poolMaster->id;
				$dayWisePoolMaster->pool_balance = $wxrk_pool;
				$dayWisePoolMaster->pool_date = date('Y-m-d');
				$dayWisePoolMaster->total_user = $totalUser;
				$dayWisePoolMaster->save();

				$dayLimit = $dayWisePoolMaster->pool_balance * $poolMaster->daily_limit;
				$maxPerUser = $poolMaster->max_coin_per_user * $dayWisePoolMaster->total_user;
				$wxrkDistLimit = 0;
				if ($dayLimit > $maxPerUser) {
					$wxrkDistLimit = $maxPerUser;
				} else {
					$wxrkDistLimit = $dayLimit;
				}
				$wxrkPerUserPerDay = $wxrkDistLimit / $dayWisePoolMaster->total_user;
				$wxrkPerMin = $wxrkPerUserPerDay / (24 * 60);

				$dayWisePoolMaster->daily_limit = $dayLimit;
				$dayWisePoolMaster->wxrk_dist_limit = $wxrkDistLimit;
				$dayWisePoolMaster->wxrk_per_user_per_day = $wxrkPerUserPerDay;
				$dayWisePoolMaster->wxrk_per_min = $wxrkPerMin;
				$dayWisePoolMaster->status = 'active';
				$dayWisePoolMaster->save();
			}

			return back()->with('success', "Pool Master added successfully for today.");

		} catch (Exception $e) {
			dd($e);
		}
	}
}
