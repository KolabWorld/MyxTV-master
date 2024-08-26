<?php namespace App\Http\Controllers\Admin\Master;

use DB;
use Auth;
use View;
use Input;
use Session;
use Datatables;
use Carbon\Carbon;

use App\User;
use App\Models\Currency;

use Illuminate\Http\Request;
use App\Helpers\GeneralHelper;
use App\Http\Controllers\AdminController;

use Illuminate\Validation\ValidationException;
use App\Lib\Validation\Master as Validator;

class CurrencyController extends AdminController {
    public function __construct(){
        parent::__construct();
        View::share('menu_id','menu_master');
        View::share('submenu_id','submenu_currency');
    }

    public function index()
    {
        $status = Session::get('status');
        return view('admin.master.currency.index',  array('status' => $status));
    }

    public function create()
    {
        $currency = new Currency;

        return view('admin.master.currency.create_edit',
            array(
                'currency' => $currency
            )
        );
    }

    public function store(Request $request) {

        $auth = \Auth::user();
		$status = array();
		$validator = (new Validator($request))->storeCurrency();

		if($validator->fails()){
			throw new ValidationException($validator);
		}

        $currency = new Currency();
        $input = $request->all();

        $currency->fill($input);
        $currency->save();

        $status = array('code' => 'success',
                'header' => 'Success',
                'messages' => array('currency successfully created')
                );

        return '<script type="text/javascript">
            parent.jQuery.colorbox.close();
            </script>';
    }

    public function edit($id)
    {
        $status = Session::get('status');
        $currency = Currency::find($id);

        return view('admin.master.currency.create_edit',
            array(
                'currency' => $currency,
                'status' => $status
            )
        );
    }

    public function update(Request $request, $id) {
        $auth = \Auth::user();
		$status = array();
		$request->request->add(['id' => $id]);
		$validator = (new Validator($request))->updateCurrency();

		if($validator->fails()){
            throw new ValidationException($validator);
		}

        $currency = Currency::find($id);

        $input = $request->all();
        $currency->fill($input);
        $currency->save();

        $status = array('code' => 'success',
                'header' => 'Success',
                'messages' => array('currency successfully edited')
                );

            return '<script type="text/javascript">
            parent.jQuery.colorbox.close();
            </script>';
    }

    public function delete($id) {
        $currency = Currency::find($id);

        if($currency ->delete()) {
            $status = array('code' => 'success',
                'header' => 'Success',
                'messages' => array('currency  successfully deleted')
            );
        } else {
            $status = array('code' => 'danger',
                'header' => 'Error',
                'messages' => array('Something went wrong, unable to delete requested currency ')
            );
        }

        return redirect('admin/master/currency')->with('status', $status);
    }

    public function restore($id) {
        $currency = Currency::withTrashed()->find($id);

        if($currency->restore()) {
            $status = array('code' => 'success',
                'header' => 'Success',
                'messages' => array('currency successfully restored')
            );
        } else {
            $status = array('code' => 'danger',
                'header' => 'Error',
                'messages' => array('Something went wrong, unable to delete requested currency')
            );
        }

        return redirect('admin/master/currency')->with('status', $status);
    }

    public function data()
    {

        $groups = Currency::withTrashed()->select('name','alias', 'deleted_at', 'created_at',  'id');

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
                    $actions .= "<a href='/admin/master/currency/$row->id/restore' class='btn btn-info btn-sm' ><span class='fa fa-refresh'></span></a>";
                }
                else {
                    $actions = "<a href='/admin/master/currency/$row->id/edit' class='btn btn-success btn-sm pull-left iframe' ><span class='glyphicon glyphicon-pencil'></span></a>";

                    $actions .= "<a href='/admin/master/currency/$row->id/delete' class='btn btn-danger btn-sm pull-left' ><span class='fa fa-trash'></span></a>";
                }

                return $actions;
            })
            ->rawColumns(['deleted_at', 'actions'])
            ->removeColumn('id')
            ->make();

    }

}
