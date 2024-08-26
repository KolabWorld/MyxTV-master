<?php

namespace App\Http\Controllers\Admin;

use App\User;
use App\Models\Order;
use App\Models\Designer;
use App\Models\OrderItem;
use App\Models\Appointment;

use Illuminate\Http\Request;
use App\Helpers\ConstantHelper;
use App\Exports\CustomerExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Controllers\AdminController;
use Carbon\Carbon;
class CustomerController extends AdminController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index(Request $request)
    {
        $status = ConstantHelper::CUSTOMER_STATUS;
        $customers = User::with('address')->orderBy('id', 'DESC');

        if ($request->search) {
            $customers->where('name', $request->search);
        }

        if ($request->status) {
            $customers->where('status', $request->status);
        }

        $customers = $customers->paginate(10);

        return view('admin.customer.index', [
            'status' => $status,
            'customers' => $customers
        ]);
    }

    public function show(Request $request, $id)
    {
        $customer = User::find($id);
        $status = ConstantHelper::STATUS;
        if ($customer) {
            $customer->load('address', 'shippingAddress', 'billingAddress');
        }

        $orderItems = OrderItem::with(['order'])->whereHas(
            'order',
            function ($q) use ($customer) {
                $q->where('user_id', $customer->id);
            }
        );

        if ($request->status) {
            $orderItems->where('status', $request->status);
        }

        $orderItems = $orderItems->paginate(5);
        $appointments = Appointment::with('user', 'designer')
            ->where('user_id', $customer->id)->get();

            return view(
            'admin.customer.view',
            array(
                'status' => $status,
                'order_status' => ConstantHelper::ORDER_STATUS,
                'customer' => $customer,
                'orderItems' => $orderItems,
                'appointments' => $appointments,
            )
        );
    }

    public function salesTrend(User $user)
    {
        $today = strtotime("today");
        $start_month = strtotime("first day of this month", $today);
        $end_month = strtotime("last day of this month", $today);
        $start_date = date("Y-m-d", $start_month);
        $end_date = date("Y-m-d", $end_month);
        $start_date_month = date("M-Y", $start_month);

        // Previous Month
        $previous_start_month = strtotime("first day of previous month", $today);
        $previous_end_month = strtotime("last day of previous month", $today);
        $previous_end_date = date("Y-m-d", $previous_end_month);
        $previous_start_date = date("Y-m-d", $previous_start_month);

        $totalSale = Order::whereUserId($user->id)
            ->whereDate('created_at', '>=', $start_date)
            ->whereDate('created_at', '<=', $end_date)->sum('invoice_total');

        $totalSalePreviousMonth = Order::whereUserId($user->id)
            ->whereDate('created_at', '>=', $previous_start_date)
            ->whereDate('created_at', '<=', $previous_end_date)->sum('invoice_total');

        $totalDiscount = Order::whereUserId($user->id)
            ->whereDate('created_at', '>=', $start_date)
            ->whereDate('created_at', '<=', $end_date)->sum('total_discount');

        $totalDiscountPreviousMonth = Order::whereUserId($user->id)
            ->whereDate('created_at', '>=', $previous_start_date)
            ->whereDate('created_at', '<=', $previous_end_date)->sum('total_discount');

        $totalAppointmet = Appointment::whereUserId($user->id)
            ->whereDate('created_at', '>=', $start_date)
            ->whereDate('created_at', '<=', $end_date)->count();

        $totalAppointmetPreviousMonth = Appointment::whereUserId($user->id)
            ->whereDate('created_at', '>=', $previous_start_date)
            ->whereDate('created_at', '<=', $previous_end_date)->count();

        // Favourite Designers Sale
        $favouriteDesigners = Designer::join('order_items', 'order_items.designer_id', '=', 'designers.id')
            ->join('orders', 'orders.id', '=', 'order_items.order_id')
            ->where('orders.user_id', '=', $user->id)
            ->whereDate('order_items.created_at', '>=', $start_date)
            ->whereDate('order_items.created_at', '<=', $end_date)
            ->selectRaw('designers.*, COALESCE(sum(total_amount),0) total_amount,COALESCE(sum(quantity),0) total_quantity')
            ->groupBy('designers.id')
            ->orderBy('total_amount', 'DESC')
            ->take(5)
            ->get();


         
        $sales = Order::where('user_id', $user->id)
            //->where('payment_status', 'paid')
            ->whereBetween('created_at', [
                Carbon::now()->startOfYear(),
                Carbon::now()->endOfYear(),
            ])->get()
            ->groupBy(function ($val) {
                return Carbon::parse($val->created_at)->format('M Y');
            });

        
        $graphData  = array(
                'month_year' => [],
                'total_amount'=> [],
                'date'=> Carbon::now()->startOfYear()->format('M Y').'-'.Carbon::now()->endOfYear()->format('M Y')
            );
        $i=0;
        foreach ($sales as $key => $item) {
            /*$currentYearSale  = array(
                'month_year' => $key,
                'total_amount'=> $item->sum('invoice_total')
            );*/
            $graphData['month_year'][$i] = $key;
            $graphData['total_amount'][$i] = $item->sum('invoice_total');
            $i++;
        } 



        

        return view(
            'admin.customer.sales-trend',
            array(
                'customer' => $user,
                'totalSale' => $totalSale,
                'totalDiscount' => $totalDiscount,
                'totalAppointmet' => $totalAppointmet,
                'start_date_month' => $start_date_month,
                'favouriteDesigners' => $favouriteDesigners,
                'totalSalePreviousMonth' => $totalSalePreviousMonth,
                'totalDiscountPreviousMonth' => $totalDiscountPreviousMonth,
                'totalAppointmetPreviousMonth' => $totalAppointmetPreviousMonth,
                'graphData'=> $graphData
            )
        );
    }

    public function customerExport(Request $request)
    {
        return Excel::download(new CustomerExport($request), 'Customers.xlsx');
    }
}