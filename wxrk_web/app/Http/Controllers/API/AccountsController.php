<?php

namespace App\Http\Controllers\API;

use Auth;
use Uuid;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Services\LoggerFactory;

use App\Http\Requests;

use App\Http\Controllers\Controller;
use App\Exceptions\NotFoundException;
use App\Exceptions\ApiGenericException;
use App\Http\Resources\User;
use App\Models\Accounts;
use Carbon\Carbon;
use App\Models\UserWallets;
use App\Models\UserExpenses;
use App\Models\UserIncomes;
use App\Models\WalletTransfers;
use App\Models\WalletTransactions;
use App\Models\Contacts;
use App\Models\Expenses;
use App\Models\PaymentRequest;
use App\Models\Transactions;

/**
 * Handling all requests related Account Controller
 */
class AccountsController extends Controller
{
    
    protected $log;

    public function __construct(LoggerFactory $logFactory)
    {
        $this->log = $logFactory->setPath('logs/api')->createLogger('account');
    }

    /**
     * Get user account
     * 
     * @param $request Request
     */
    public function index()
    {
        // get user from api token
        $user = Auth::guard('api')->user();
        $account = UserWallets::where('user_id', '=', $user->id)->first();
        $expenses = UserExpenses::where('wallet_id', '=', $account->id)
            ->orderBy('id', 'DESC')
            ->where('owner','=', UserExpenses::OWNER_USER)
            ->where('status','=', UserExpenses::STATUS_PENDING)
            ->get();
        $incomes = UserIncomes::where('wallet_id', '=', $account->id)
            ->orderBy('id', 'DESC')
            ->limit(10)
            ->get();


        $amountRecieved = WalletTransfers::where('to_wallet', '=', $account->id)
            ->orderBy('id', 'DESC')
            ->join('user_wallets as uw','uw.id', '=', 'wallet_transfers.from_wallet')
            ->join('users as u','u.id', '=', 'uw.user_id')
            ->select('wallet_transfers.*','u.name')
            ->where('wallet_transfers.status', '=', WalletTransfers::STATUS_PENDING)
            ->get();
        $amountTransfered = WalletTransfers::where('from_wallet', '=', $account->id)
            ->join('user_wallets as uw','uw.id', '=', 'wallet_transfers.to_wallet')
            ->join('users as u','u.id', '=', 'uw.user_id')
            ->orderBy('id', 'DESC')
            ->select('wallet_transfers.*','u.name')
            ->where('wallet_transfers.status', '=', WalletTransfers::STATUS_PENDING)
            ->get();

        $paymentRequests = PaymentRequest::where('user_id', $user->id)
            ->where('status', PaymentRequest::STATUS_PENDING)
            ->get();


        return array(
            'account' => $account,
            'expenses' => $expenses,
            'incomes' => $incomes,
            'recieved' => $amountRecieved,
            'tranfer' => $amountTransfered,
            'paymentRequests' => $paymentRequests
        );
    }

    public function storeExpense(Request $request) {

        $this->log->info("AddExpense AllData: ". json_encode($request->all()));

        try {
            $user = Auth::guard('api')->user();

            if(!in_array($request->type, array('travel'))) {
                if(!$request->file) {
                    throw new ApiGenericException("Bill copy is required for expense");
                }
            }

            $account = UserWallets::where('user_id', '=', $user->id)->first();
            $transactionNo = Uuid::generate(4);

            $amount = floatval($request->amount);

            $expense = new UserExpenses;

            $expense->wallet_id = $account->id;
            $expense->description = $request->description;
            $expense->manager_id = $request->manager_id;
            $expense->amount = $amount;
            $expense->owner = UserExpenses::OWNER_USER;
            $expense->date = $request->date ?: date("Y-m-d");
            $expense->transaction_no = $transactionNo;

            if(isset($request->type) && $request->type) {
                $expense->type = $request->type;

                if($request->type == 'labour' && $request->type_id) {
                    $expense->type_id = $request->type_id;
                    $contact = Contacts::find($request->type_id);
                    if ($contact) {
                        $expense->description .= ' To Labour: '.$contact->name;
                    }
                }
            }

            if ($request->file) {

                //get the base-64 from data
                $base64_str = substr($request->file, strpos($request->file, ",")+1);

                //decode base64 string
                $image = base64_decode($base64_str);

                $safeName = $transactionNo.'.'.'png';
                // Storage::disk('public')->put('eejaz/'.$safeName, $image);
                $path = Storage::disk('public')->put('expense/'.$user->id.'/'.$safeName, $image);
                $expense->ebill = 'expense/'.$user->id.'/'.$safeName;

                $this->log->info("AddExpense file: ". $safeName ." ,Path: ".$expense->ebill);
            }

            $expense->save();

            $account->amount -= $amount;
            $account->save();
            $this->addTransaction($account->id, $transactionNo, -($amount), $account->amount);
            return $expense;
            
        } catch (\Exception $e) {
            $this->log->info("AddExpense Error: " . $e->getMessage());
            throw new ApiGenericException("Could not add expense, " . $e->getMessage());
        }
    }

    public function storeExpenseV2(Request $request) {

        $this->log->info("AddExpense AllData: ". json_encode($request->all()));

        try {
            $user = Auth::guard('api')->user();

            if(!in_array($request->type, array('travel'))) {
                if(!$request->file) {
                    throw new ApiGenericException("Bill copy is required for expense");
                }
            }

            $account = UserWallets::where('user_id', '=', $user->id)->first();
            $transactionNo = Uuid::generate(4);

            $amount = floatval($request->amount);

            $expense = new UserExpenses;

            $expense->wallet_id = $account->id;
            $expense->description = $request->description;
            $expense->manager_id = $request->manager_id;
            $expense->amount = $amount;
            $expense->owner = UserExpenses::OWNER_USER;
            $expense->date = $request->date ?: date("Y-m-d");
            $expense->transaction_no = $transactionNo;

            if(isset($request->type) && $request->type) {
                $expense->type = $request->type;

                if($request->type == 'labour' && $request->type_id) {
                    $expense->type_id = $request->type_id;
                    $contact = Contacts::find($request->type_id);
                    if ($contact) {
                        $expense->description .= ' To Labour: '.$contact->name;
                    }
                }
            }

            if ($request->hasFile('file')) {

                $file = $request->file('file');
                $file_extension = $file->getClientOriginalExtension();

                $safeName = $transactionNo.'.'.$file_extension;
                $destination_path = storage_path().'/app/public/expense/'.$user->id;
                $file = $request->file('file')->move($destination_path,$safeName);
                $expense->ebill = 'expense/'.$user->id.'/'.$safeName;

                $this->log->info("AddExpense file: ". $safeName ." ,Path: ".$expense->ebill);
            }

            $expense->save();

            $account->amount -= $amount;
            $account->save();
            $this->addTransaction($account->id, $transactionNo, -($amount), $account->amount);
            return $expense;
            
        } catch (\Exception $e) {
            $this->log->info("AddExpense Error: " . $e->getMessage());
            throw new ApiGenericException("Could not add expense, " . $e->getMessage());
        }
    }

    // add expense to account 
    public function storeIncome(Request $request)
    {
        try {
            $user = Auth::guard('api')->user();
            $userWallet = UserWallets::where('user_id', '=', $user->id)->first();
            $transactionNo = Uuid::generate(4);

            $amount = floatval($request->amount);

            $userIncome = new UserIncomes;
            $userIncome->wallet_id = $userWallet->id;
            $userIncome->amount = $amount;
            $userIncome->transaction_no = $transactionNo;
            $userIncome->description = $request->description;
            $userIncome->date = $request->date ?: date("Y-m-d");
            $userIncome->save();

            $userWallet->amount += $amount;
            $userWallet->save();
            $this->addTransaction($userWallet->id, $transactionNo, $amount, $userWallet->amount);

            return array('Income added successfully');
        } catch (Exception $e) {
            $this->log->info("AddExpense Error: " . $e->getMessage());
            throw new ApiGenericException("Could not add expense, " . $e->getMessage());
        }
    }

    public function getExpenses($month='') {

        $user = Auth::guard('api')->user();
        $account = UserWallets::where('user_id', '=', $user->id)->first();
        $month = $month ?: Carbon::today()->format('Y-m');
        $data = UserExpenses::whereRaw("date LIKE '$month%'")
                        ->where('owner','=', UserExpenses::OWNER_USER)
                        ->where('wallet_id', '=', $account->id)
                        ->get();
        return $data;
    }

    public function getIncomes($month='') {

        $user = Auth::guard('api')->user();
        $account = UserWallets::where('user_id', '=', $user->id)->first();
        $month = $month ?: Carbon::today()->format('Y-m');
        $data = UserIncomes::where('wallet_id', '=', $account->id)
                        ->whereRaw("date LIKE '$month%'")
                        ->get();

        return $data;
    }

     // add expense to account 
    public function postTransfer(Request $request)
    {

        $user = Auth::guard('api')->user();
        $userWallet = UserWallets::where('user_id', '=', $user->id)->first();
        $amount = floatval($request->amount);

        if (!$userWallet) {
            $userWallet = new UserWallets;
            $userWallet->user_id = $user->id;
            $userWallet->save();
        }

        $toUser = $request->user_id;
        $toUserWallet = UserWallets::where('user_id', '=', $request->user_id)->first();

        if (!$toUserWallet) {
            $toUserWallet = new UserWallets;
            $toUserWallet->user_id = $request->user_id;
            $toUserWallet->save();
        }

        $transactionNo = Uuid::generate(4);
        $transfer = new WalletTransfers;
        $transfer->from_wallet = $userWallet->id;
        $transfer->to_wallet = $toUserWallet->id;
        $transfer->amount = $amount;
        $transfer->description = $request->description;
        $transfer->date = $request->date ?: date('Y-m-d');
        $transfer->transaction_no = $transactionNo;
        $transfer->status = WalletTransfers::STATUS_PENDING;
        if($transfer->save()) {

            $userWallet->amount -= $amount;
            $userWallet->save();

            $this->addTransaction($userWallet->id, $transactionNo, -($amount), $userWallet->amount);


            return array('Amount transfered successfully');
        } else {

            throw new ApiGenericException('Something went wrong! Unable to transfer.');
        }  
    }

     // add payment request to account 
     public function requestPayment(Request $request)
     {
 
        $user = Auth::guard('api')->user();

        $transactionNo = Uuid::generate(4);
        $paymentRequest = new PaymentRequest();
        $paymentRequest->user_id = $user->id;
        $paymentRequest->amount = $request->amount;
        $paymentRequest->description = $request->description;
        $paymentRequest->transaction_no = $transactionNo;
        $paymentRequest->status = PaymentRequest::STATUS_PENDING;
        $paymentRequest->save();
        return array('payment request sent successfully');
        
     }

    public function transferAction($id, $status) {

        $transfer = WalletTransfers::find($id);

        if($transfer->status !== WalletTransfers::STATUS_PENDING) {
            return array('Transaction already updated');
        }

        $transactionNo = $transfer->transaction_no;
        if($status) {
            $toUserWallet = $transfer->toWallet;
            $toUserWallet->amount += $transfer->amount;
            $toUserWallet->save();
            $transfer->status = WalletTransfers::STATUS_APPROVED;
            $transfer->save();
            $this->addTransaction($toUserWallet->id, $transactionNo, $transfer->amount, $toUserWallet->amount);

        }
        else {
            $fromUserWallet = $transfer->fromWallet;
            $fromUserWallet->amount += $transfer->amount;
            $fromUserWallet->save();
            $transfer->status = WalletTransfers::STATUS_REJECTED;
            $transfer->save();
            $this->addTransaction($fromUserWallet->id, $transactionNo, $transfer->amount, $fromUserWallet->amount);

        }

        return array('Amount transfered successfully');
    }

    public function amountRecieved($month='') {

        $user = Auth::guard('api')->user();
        $account = UserWallets::where('user_id', '=', $user->id)->first();
        $month = $month ?: Carbon::today()->format('Y-m');
        $data = WalletTransfers::whereRaw("date LIKE '$month%'")
                        ->where('to_wallet', '=', $account->id)
                        ->join('user_wallets as uw','uw.id', '=', 'wallet_transfers.from_wallet')
                        ->join('users as u','u.id', '=', 'uw.user_id')
                        ->select('wallet_transfers.*','u.name')
                        ->get();
        return $data;
    }

    public function amountTransfered($month='') {

        $user = Auth::guard('api')->user();
        $account = UserWallets::where('user_id', '=', $user->id)->first();
        $month = $month ?: Carbon::today()->format('Y-m');
        $data = WalletTransfers::where('from_wallet', '=', $account->id)
                        ->whereRaw("date LIKE '$month%'")
                        ->join('user_wallets as uw','uw.id', '=', 'wallet_transfers.to_wallet')
                        ->join('users as u','u.id', '=', 'uw.user_id')
                        ->select('wallet_transfers.*','u.name')
                        ->get();

        return $data;
    }

    protected function addTransaction($walletId, $transactionNo, $amount, $closingBalance) {
        $transaction = new WalletTransactions;
        $transaction->wallet_id = $walletId;
        $transaction->transaction_no = $transactionNo;
        $transaction->amount = $amount;
        $transaction->closing_balance = $closingBalance;
        $transaction->save();
    }

    public function accountlist() {
        return Accounts::get();
    }

    public function expensePendingRequests() {

        $user = Auth::guard('api')->user();

        $userExpenses = UserExpenses::where('status', '=', UserExpenses::STATUS_PENDING)
            ->where('manager_id', $user->id)
            ->with('wallet')
            ->get();
        return $userExpenses;
    }

    public function expenseRequests($month = '') {

        $user = Auth::guard('api')->user();
        $month = $month ?: Carbon::today()->format('Y-m');
        $userExpenses = UserExpenses::whereRaw("date LIKE '$month%'")
            ->where('manager_id', $user->id)
            ->with('wallet')
            ->get();
        return $userExpenses;
    }

    public function paymentPendingRequests() {

        $user = Auth::guard('api')->user();

        $userExpenses = PaymentRequest::where('status', '=', PaymentRequest::STATUS_PENDING)
            ->with('user')
            ->get();
        return $userExpenses;
    }

    public function paymentRequests() {

        $user = Auth::guard('api')->user();

        $expenses = UserExpenses::where('status', '=', UserExpenses::STATUS_PENDING)
            ->with(['wallet', 'manager']);

        $paymentRequests = [];
        if($user->hasRole('admin')) {
            $paymentRequests = PaymentRequest::where('status', '=', UserExpenses::STATUS_PENDING)
                ->with('user')
                ->get();
        }
        else {
            $expenses = $expenses->where('manager_id', '=', $user->id);
        }
       
        $expenses = $expenses->get();
        return [
            'expenses' => $expenses,
            'paymentRequests' => $paymentRequests
        ];
    }

    public function viewPaymentRequest($id) {

        $requestPayment = PaymentRequest::select('payment_requests.*', 'users.name as user_name')
            ->leftJoin('users', 'users.id', '=', 'payment_requests.user_id')
            ->find($id);
        return [
            'paymentRequest' => $requestPayment
        ];
    }

    public function myPaymentPendingRequests() {

        $user = Auth::guard('api')->user();

        $userExpenses = PaymentRequest::where('status', '=', PaymentRequest::STATUS_PENDING)
            ->where('user_id', $user->id)
            ->get();
        return $userExpenses;
    }

    public function myPaymentRequests($month = '') {

        $user = Auth::guard('api')->user();
        $month = $month ?: Carbon::today()->format('Y-m');
        $userExpenses = PaymentRequest::whereRaw("created_at LIKE '$month%'")
            ->where('user_id', $user->id)
            ->get();
        return $userExpenses;
    }

    public function updatePaymentRequests(Request $request) {

        $user = Auth::guard('api')->user();

        $record = PaymentRequest::find($request->id);

        if(!$record) {
            throw new ApiGenericException("No Record found");
        }

        if($request->status == PaymentRequest::STATUS_REJECTED) {
            $record->status = PaymentRequest::STATUS_REJECTED;
            $record->remark = $request->remark;
            $record->updated_by = $user->id;
            $record->save();

            return $record;
        }

        if($request->status != PaymentRequest::STATUS_APPROVED) {
            throw new ApiGenericException("Invalid status");
        }

        if($record->status == PaymentRequest::STATUS_APPROVED) {
            throw new ApiGenericException("Already approved");
        }

        if(!$request->account_id) {
            throw new ApiGenericException("Account is required");
        }

        $accountId = $request->account_id;

        $userWallet = UserWallets::where('user_id', '=', $record->user_id)->first();

        if (!$userWallet) {
            $userWallet = new UserWallets;
            $userWallet->user_id = $record->user_id;
            $userWallet->save();
        }
        $transactionNo = $record->transaction_no;
        $amount = floatval($record->amount);
        $expense = new Expenses();
        $expense->account_id = $request->account_id;
        $expense->amount = $amount;
        $expense->reference = 'User Payment Request';
        $expense->description = $record->description;
        $expense->date = date('Y-m-d');
        $expense->created_by = $user->id;
        $expense->transaction_no = $transactionNo;
        $expense->channel = Expenses::CHANNEL_TRANSFER;
        $expense->channel_uid = $record->user_id;

        if($expense->save()) {

            $this->addAccountTransaction($accountId, $transactionNo, -($amount));
            $userIncome = new UserIncomes;
            $userIncome->wallet_id = $userWallet->id;
            $userIncome->amount = $amount;
            $userIncome->transaction_no = $transactionNo;
            $userIncome->description = $request->description;
            $userIncome->date = date('Y-m-d');
            $userIncome->save();

            $userWallet->amount += $amount;
            $userWallet->save();

            $this->addTransaction($userWallet->id, $transactionNo, $amount, $userWallet->amount);


            $account = Accounts::find($accountId);
            $account->amount -= $amount;
            $account->save();

            $record->status = PaymentRequest::STATUS_APPROVED;
            $record->remark = $request->remark;
            $record->updated_by = $user->id;
            $record->save();

            return $record;
        } else {
            throw new ApiGenericException("Unable to update");
        }  
    }

    public function viewUserExpense($id) {

        $expense = UserExpenses::select('user_expenses.*', 'users.name as user_name')
            ->leftJoin('user_wallets', 'user_wallets.id', '=', 'user_expenses.wallet_id')
            ->leftJoin('users', 'users.id', '=', 'user_wallets.user_id')
            ->find($id);

        return [
            'expense' => $expense
        ];
    }

    public function updateUserExpense(Request $request) {

        $record = UserExpenses::find($request->id);

        if(!$record) {
            throw new ApiGenericException("No Record found");
        }

        if($request->status == UserExpenses::STATUS_APPROVED) {
            $record->status = UserExpenses::STATUS_APPROVED;
            $record->save();        
            return $record;
        }

        if($request->status != UserExpenses::STATUS_REJECTED) {
            throw new ApiGenericException("Invalid status");
        }

        if($record->status == UserExpenses::STATUS_REJECTED) {
            throw new ApiGenericException("Already rejected");
        }

        $record->status = UserExpenses::STATUS_REJECTED;
        $record->remark = $request->remark;
        $record->save();


        $wallet = $record->wallet;
        $wallet->amount = $wallet->amount + $record->amount;
        $wallet->save();
        $this->addWalletTransaction($wallet->id, $record->transaction_no, $record->amount, $wallet->amount);

        return $record;
       
    }

    protected function addAccountTransaction($accountId, $transactionNo, $amount) {
        $transaction = new Transactions();
        $transaction->account_id = $accountId;
        $transaction->transaction_no = $transactionNo;
        $transaction->amount = $amount;
        $transaction->save();
    }

    protected function addWalletTransaction($walletId, $transactionNo, $amount, $closingBalance) {
        $transaction = new WalletTransactions;
        $transaction->wallet_id = $walletId;
        $transaction->transaction_no = $transactionNo;
        $transaction->amount = $amount;
        $transaction->closing_balance = $closingBalance;
        $transaction->save();
    }
}
