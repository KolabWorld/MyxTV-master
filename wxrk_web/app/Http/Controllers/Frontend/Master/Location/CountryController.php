<?php
namespace App\Http\Controllers\Frontend\Master\Location;

use DB;
use Auth;
use View;
use Input;
use Session;
use Datatables;
use Carbon\Carbon;

use App\Models\Country;

use Illuminate\Http\Request;
use App\Helpers\GeneralHelper;
use App\Http\Controllers\AdminController;

use Illuminate\Validation\ValidationException;
use App\Lib\Validation\LocationMaster as Validator;

class CountryController extends AdminController {
    public function __construct(){
        parent::__construct();
        View::share('menu_id','menu_master');
        View::share('submenu_id','submenu_countries');
    }

    public function index()
    {
        $status = Session::get('status');

        $records = Country::paginate(10);

        return view('frontend.master.location.country.index',  array(
            'tab' => 'countries',
            'status' => $status,
            'records' => $records,
        ));
    }

    public function create()
    {
        $country = new Country;
        return view('frontend.master.location.country.create_edit',
            array(
                'country' => $country
            )
        );
    }

    public function store(Request $request) {
        $auth = \Auth::user();
		$status = array();
		$validator = (new Validator($request))->storeCountry();

		if($validator->fails()){
			throw new ValidationException($validator);
        }

        $country = new Country();
        $input = $request->all();
        $country->fill($input);
        $country->save();

        $status = array('code' => 'success',
            'header' => 'Success',
            'messages' => array('New country successfully created')
        );

        return '<script type="text/javascript">
            parent.jQuery.colorbox.close();
            </script>';
    }

    public function edit($id)
    {
        $status = Session::get('status');
        $country = Country::find($id);

        return view('frontend.master.location.country.create_edit', array('country' => $country, 'status' => $status));
    }

    public function update(Request $request, $id) {
        $auth = \Auth::user();
		$status = array();
		$request->request->add(['id' => $id]);
		$validator = (new Validator($request))->updateCountry();

		if($validator->fails()){
            throw new ValidationException($validator);
        }

        $country = Country::find($id);
        $input = $request->all();
        $country->fill($input);
        $country->save();

        $status = array('code' => 'success',
                'header' => 'Success',
                'messages' => array('New country successfully edited')
                );

        return '<script type="text/javascript">
        parent.jQuery.colorbox.close();
        </script>';
    }

    public function delete($id) {
        $country = Country::find($id);

        if($country->delete()) {
            $status = array('code' => 'success',
                'header' => 'Success',
                'messages' => array('country successfully deleted')
            );
        } else {
            $status = array('code' => 'danger',
                'header' => 'Error',
                'messages' => array('Something went wrong, unable to delete requested country')
            );
        }

        return redirect('admin/master/location/countries')->with('status', $status);
    }

    public function restore($id) {
        $country = Country::withTrashed()->find($id);

        if($country->restore()) {
            $status = array('code' => 'success',
                'header' => 'Success',
                'messages' => array('country successfully restored')
            );
        } else {
            $status = array('code' => 'danger',
                'header' => 'Error',
                'messages' => array('Something went wrong, unable to delete requested country')
            );
        }

        return redirect('admin/master/location/countries')->with('status', $status);
    }

    public function data()
    {

        $groups = Country::withTrashed()->select('name','dial_code', 'code', 'deleted_at', 'created_at',  'id')
            ->orderBy('name','ASC');

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
                    $actions .= "<a href='/admin/master/location/country/$row->id/restore' class='btn btn-info btn-sm' ><span class='fa fa-refresh'></span></a>";
                }
                else {
                    $actions = "<a href='/admin/master/location/country/$row->id/edit' class='btn btn-success btn-sm pull-left iframe' ><span class='glyphicon glyphicon-pencil'></span></a>";

                    $actions .= "<a href='/admin/master/location/country/$row->id/delete' class='btn btn-danger btn-sm pull-left' ><span class='fa fa-trash'></span></a>";
                }

                return $actions;
            })
            ->rawColumns(['deleted_at', 'actions'])
            ->removeColumn('id')
            ->make();

    }

}
