<?php namespace App\Http\Controllers\Admin\Master;

use DB;
use Auth;
use View;
use Input;
use Session;
use Datatables;
use Carbon\Carbon;

use App\User;
use App\Models\PaymentCycle;

use Illuminate\Http\Request;
use App\Helpers\GeneralHelper;
use App\Http\Controllers\AdminController;

use Illuminate\Validation\ValidationException;
use App\Lib\Validation\Master as Validator;

class PaymentCycleController extends AdminController {
    public function __construct(){
        parent::__construct();
        View::share('menu_id','menu_master');
        View::share('submenu_id','submenu_payment_cycle');
    }

    public function index()
    {
        $status = Session::get('status');
        return view('admin.master.payment-cycle.index',  array('status' => $status));
    }

    public function create()
    {
        $paymentCycle = new PaymentCycle;

        return view('admin.master.payment-cycle.create_edit',
            array(
                'paymentCycle' => $paymentCycle
            )
        );
    }

    public function store(Request $request) {
        $auth = \Auth::user();
		$status = array();
		$validator = (new Validator($request))->storePaymentCycle();

		if($validator->fails()){
			throw new ValidationException($validator);
		}

        $paymentCycle = new PaymentCycle();
        $input = $request->all();

        $paymentCycle->fill($input);
        $paymentCycle->save();

        $status = array('code' => 'success',
                'header' => 'Success',
                'messages' => array('Payment Cycle successfully created')
                );

        return '<script type="text/javascript">
            parent.jQuery.colorbox.close();
            </script>';
    }

    public function edit($id)
    {
        $status = Session::get('status');
        $paymentCycle = PaymentCycle::find($id);

        return view('admin.master.payment-cycle.create_edit',
            array(
                'paymentCycle' => $paymentCycle,
                'status' => $status
            )
        );
    }

    public function update(Request $request, $id) {
        $auth = \Auth::user();
		$status = array();
		$request->request->add(['id' => $id]);
		$validator = (new Validator($request))->updatePaymentCycle();

		if($validator->fails()){
            throw new ValidationException($validator);
		}

        $paymentCycle = PaymentCycle::find($id);

        $input = $request->all();
        $paymentCycle->fill($input);
        $paymentCycle->save();

        $status = array('code' => 'success',
                'header' => 'Success',
                'messages' => array('Payment Cycle successfully edited')
                );

            return '<script type="text/javascript">
            parent.jQuery.colorbox.close();
            </script>';
    }

    public function delete($id) {
        $paymentCycle = PaymentCycle::find($id);

        if($paymentCycle ->delete()) {
            $status = array('code' => 'success',
                'header' => 'Success',
                'messages' => array('Payment Cycle successfully deleted')
            );
        } else {
            $status = array('code' => 'danger',
                'header' => 'Error',
                'messages' => array('Something went wrong, unable to delete requested paymentCycle ')
            );
        }

        return redirect('admin/master/payment-cycles')->with('status', $status);
    }

    public function restore($id) {
        $paymentCycle = PaymentCycle::withTrashed()->find($id);

        if($paymentCycle->restore()) {
            $status = array('code' => 'success',
                'header' => 'Success',
                'messages' => array('Payment Cycle successfully restored')
            );
        } else {
            $status = array('code' => 'danger',
                'header' => 'Error',
                'messages' => array('Something went wrong, unable to delete requested paymentCycle')
            );
        }

        return redirect('admin/master/payment-cycles')->with('status', $status);
    }

    public function data()
    {

        $groups = PaymentCycle::withTrashed()->select('name', 'deleted_at', 'created_at',  'id');

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
                    $actions .= "<a href='/admin/master/payment-cycle/$row->id/restore' class='btn btn-info btn-sm' ><span class='fa fa-refresh'></span></a>";
                }
                else {
                    $actions = "<a href='/admin/master/payment-cycle/$row->id/edit' class='btn btn-success btn-sm iframe' ><span class='glyphicon glyphicon-pencil'></span></a>";

                    $actions .= "<a href='/admin/master/payment-cycle/$row->id/delete' class='btn btn-danger btn-sm' ><span class='fa fa-trash'></span></a>";
                }

                return $actions;
            })
            ->rawColumns(['deleted_at', 'actions'])
            ->removeColumn('id')
            ->make();

    }

}
