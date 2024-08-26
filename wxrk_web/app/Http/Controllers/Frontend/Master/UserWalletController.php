<?php
namespace App\Http\Controllers\Frontend\Master;

use Auth;

use App\Models\UserWallet;
use App\Models\DayWiseSummary;
use App\Models\WalletTransaction;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\AdminController;

use Illuminate\Validation\ValidationException;
use App\Lib\Validation\StaticContent as StaticContentValidator;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;
use App\Helpers\ConstantHelper;


class UserWalletController extends AdminController
{
	public function __construct()
	{
		parent::__construct();
	}

	public function index(Request $request)
	{
		$user = \Auth::user();

		$userWallets = UserWallet::with(['user'])->orderBy('id', 'DESC');

		$userWallets = $userWallets->paginate(10);
		$totalBalance = UserWallet::sum('wxrk_balance');

		return view('frontend.master.user-wallet.index', array(
			'tab' => 'user-wallet',
			'user' => $user,
			'request' => $request,
			'userWallets' => $userWallets,
			'totalBalance' => $totalBalance,
		));
	}

	public function dayWiseSummary($id)
	{
		$user = Auth::user();
       
		$userWallet = UserWallet::find($id);
		$dayWiseSummary = DayWiseSummary::where('user_id', $userWallet->user_id)
			->orderBy('id', 'DESC')
			->paginate(10);
		
		return view('frontend.master.user-wallet.day-wise-summary', array(
			'tab' => 'user-wallet',
			'user' => $user,
			'userWallet' => $userWallet,
			'dayWiseSummary' => $dayWiseSummary
		));
	}

	public function transactions($id, $type)
	{
		$user = Auth::user();
        
		$userWallet = '';
		$transactions = WalletTransaction::orderBy('id', 'DESC');
		if($type == 'day-wise'){
			$userWallet = DayWiseSummary::with(['user'])->find($id);
			$transactions = $transactions->whereDate('created_at', date('Y-m-d', strtotime($userWallet->created_at)))
				->where('user_id', $userWallet->user_id);	
		}
		else{
			$userWallet = UserWallet::with(['user'])->find($id);
			$transactions = $transactions->where('user_id', $userWallet->user_id);
		}
		$transactions = $transactions->paginate(10);
		
		return view('frontend.master.user-wallet.wallet-transactions', array(
			'tab' => 'user-wallet',
			'user' => $user,
			'userWallet' => $userWallet,
			'transactions' => $transactions
		));
	}

}
