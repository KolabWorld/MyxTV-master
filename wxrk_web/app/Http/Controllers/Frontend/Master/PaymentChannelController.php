<?php namespace App\Http\Controllers\Admin\Master;

use DB;
use Auth;
use View;
use Input;
use Session;
use Datatables;
use Carbon\Carbon;

use App\User;
use App\Models\PaymentChannel;

use Illuminate\Http\Request;
use App\Helpers\GeneralHelper;
use App\Http\Controllers\AdminController;

use Illuminate\Validation\ValidationException;
use App\Lib\Validation\Master as Validator;

class PaymentChannelController extends AdminController {
    public function __construct(){
        parent::__construct();
        View::share('menu_id','menu_master');
        View::share('submenu_id','submenu_payment_channel');
    }

    public function index()
    {
        $status = Session::get('status');
        return view('admin.master.payment-channel.index',  array('status' => $status));
    }

    public function create()
    {
        $paymentChannel = new PaymentChannel;

        return view('admin.master.payment-channel.create_edit',
            array(
                'paymentChannel' => $paymentChannel
            )
        );
    }

    public function store(Request $request) {
        $auth = \Auth::user();
		$status = array();
		$validator = (new Validator($request))->storePaymentChannel();

		if($validator->fails()){
			throw new ValidationException($validator);
		}

        $paymentChannel = new PaymentChannel();
        $input = $request->all();

        $paymentChannel->fill($input);
        $paymentChannel->save();

        $status = array(
            'code' => 'success',
            'header' => 'Success',
            'messages' => array('Payment Channel successfully created')
        );

        return '<script type="text/javascript">
            parent.jQuery.colorbox.close();
            </script>';
    }

    public function edit($id)
    {
        $status = Session::get('status');
        $paymentChannel = PaymentChannel::find($id);

        return view('admin.master.payment-channel.create_edit',
            array(
                'paymentChannel' => $paymentChannel,
                'status' => $status
            )
        );
    }

    public function update(Request $request, $id) {
        $auth = \Auth::user();
		$status = array();
		$request->request->add(['id' => $id]);
		$validator = (new Validator($request))->updatePaymentChannel();

		if($validator->fails()){
            throw new ValidationException($validator);
		}

        $paymentChannel = PaymentChannel::find($id);

        $input = $request->all();
        $paymentChannel->fill($input);
        $paymentChannel->save();

        $status = array('code' => 'success',
                'header' => 'Success',
                'messages' => array('Payment Channel successfully edited')
                );

            return '<script type="text/javascript">
            parent.jQuery.colorbox.close();
            </script>';
    }

    public function delete($id) {
        $paymentChannel = PaymentChannel::find($id);

        if($paymentChannel ->delete()) {
            $status = array('code' => 'success',
                'header' => 'Success',
                'messages' => array('Payment Channel successfully deleted')
            );
        } else {
            $status = array('code' => 'danger',
                'header' => 'Error',
                'messages' => array('Something went wrong, unable to delete requested paymentChannel ')
            );
        }

        return redirect('admin/master/payment-channels')->with('status', $status);
    }

    public function restore($id) {
        $paymentChannel = PaymentChannel::withTrashed()->find($id);

        if($paymentChannel->restore()) {
            $status = array('code' => 'success',
                'header' => 'Success',
                'messages' => array('Payment Channel successfully restored')
            );
        } else {
            $status = array('code' => 'danger',
                'header' => 'Error',
                'messages' => array('Something went wrong, unable to delete requested paymentChannel')
            );
        }

        return redirect('admin/master/payment-channels')->with('status', $status);
    }

    public function data()
    {

        $groups = PaymentChannel::withTrashed()->select(
            'name', 
            'alias', 
            'access_id', 
            'access_code', 
            'access_secret', 
            'deleted_at', 
            'created_at',  
            'id'
        );

        return Datatables::of($groups)
            ->editColumn('created_at', function($row) {
                $x = "{$row->created_at}";
                return date('M d, Y h:i A',strtotime($x));
            })
            ->editColumn('deleted_at', function($row) {
				if($row->deleted_at) {
					return '<span class=\'glyphicon glyphicon-remove\'></span>';
				} else {
					return '<span class="glyphicon glyphicon-ok"></span>';
				}
			})
            ->addColumn('actions', function($row) {

                $actions = '';
                if ($row->deleted_at) {
                    $actions .= "<a href='/admin/master/payment-channel/$row->id/restore' class='btn btn-info btn-sm' ><span class='fa fa-refresh'></span></a>";
                }
                else {
                    $actions = "<a href='/admin/master/payment-channel/$row->id/edit' class='btn btn-success btn-sm iframe' ><span class='glyphicon glyphicon-pencil'></span></a>";

                    $actions .= "<a href='/admin/master/payment-channel/$row->id/delete' class='btn btn-danger btn-sm' ><span class='fa fa-trash'></span></a>";
                }

                return $actions;
            })
            ->rawColumns(['deleted_at', 'actions'])
            ->removeColumn('id')
            ->make();

    }

}
