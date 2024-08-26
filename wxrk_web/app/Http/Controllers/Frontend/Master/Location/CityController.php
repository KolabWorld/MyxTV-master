<?php
namespace App\Http\Controllers\Frontend\Master\Location;

use DB;
use Auth;
use View;
use Input;
use Session;
use Datatables;
use Carbon\Carbon;

use App\Models\User;
use App\Models\City;
use App\Models\State;
use App\Models\Country;

use Illuminate\Http\Request;
use App\Helpers\GeneralHelper;
use App\Http\Controllers\AdminController;

use Illuminate\Validation\ValidationException;
use App\Lib\Validation\LocationMaster as Validator;

class CityController extends AdminController {
    public function __construct(){
        parent::__construct();
        View::share('menu_id','menu_master');
        View::share('submenu_id','submenu_cities');
    }

    public function index()
    {
        $status = Session::get('status');

        $records = City::paginate(10);

        return view('frontend.master.location.city.index',  array(
            'tab' => 'cities',
            'status' => $status,
            'records' => $records,
        ));
    }

    public function create()
    {
        $countries = Country::get();
        $city = new City;
        return view('frontend.master.location.city.create_edit',
            array(
                'city' => $city,
                'countries' => $countries,
            )
        );
    }

    public function store(Request $request) {
        $auth = \Auth::user();
		$status = array();
		$validator = (new Validator($request))->storeCity();

		if($validator->fails()){
			throw new ValidationException($validator);
        }

        $city = new City();
        $city->fill($request->all());
        $city->save();

        $status = array('code' => 'success',
            'header' => 'Success',
            'messages' => array('New city successfully created')
        );

        return '<script type="text/javascript">
                    parent.jQuery.colorbox.close();
                </script>';
    }

    public function edit($id)
    {
        $status = Session::get('status');
        $countries = Country::get();
        $city = City::find($id);

        return view('frontend.master.location.city.create_edit',
            array(
                'city' => $city,
                'status' => $status,
                'countries' => $countries,
            )
        );
    }

    public function update(Request $request, $id) {
        $auth = \Auth::user();
		$status = array();
		$request->request->add(['id' => $id]);
		$validator = (new Validator($request))->updateCity();

		if($validator->fails()){
            throw new ValidationException($validator);
        }

        $city = City::find($id);
        $city->fill($request->all());
        $city->save();

        $status = array('code' => 'success',
                'header' => 'Success',
                'messages' => array('City successfully edited')
                );

        return '<script type="text/javascript">
                    parent.jQuery.colorbox.close();
                </script>';
    }

    public function delete($id) {
        $city = City::find($id);

        if($city->delete()) {
            $status = array('code' => 'success',
                'header' => 'Success',
                'messages' => array('City successfully deleted')
            );
        } else {
            $status = array('code' => 'danger',
                'header' => 'Error',
                'messages' => array('Something went wrong, unable to delete requested city')
            );
        }

        return redirect('admin/master/location/cities')->with('status', $status);
    }

    public function restore($id) {
        $city = City::withTrashed()->find($id);

        if($city->restore()) {
            $status = array('code' => 'success',
                'header' => 'Success',
                'messages' => array('City successfully restored')
            );
        } else {
            $status = array('code' => 'danger',
                'header' => 'Error',
                'messages' => array('Something went wrong, unable to delete requested city')
            );
        }

        return redirect('admin/master/location/cities')->with('status', $status);
    }

    public function data()
    {

        $cities = City::withTrashed()
        ->select(
            'countries.name as country_name',
            'states.name as state_name',
            'cities.name as name',
            'cities.deleted_at',
            'cities.created_at',
            'cities.id'
        )
        ->leftJoin('states','states.id','=','cities.state_id')
        ->leftJoin('countries','countries.id','=','states.country_id')
        ->where('countries.name','like','nigeria')
        ->orderBy('countries.name','ASC');

        return Datatables::of($cities)
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
                    $actions .= "<a href='/admin/master/location/city/$row->id/restore' class='btn btn-info btn-sm' ><span class='fa fa-refresh'></span></a>";
                }
                else {
                    $actions = "<a href='/admin/master/location/city/$row->id/edit' class='btn btn-success btn-sm iframe' ><span class='glyphicon glyphicon-pencil'></span></a>";

                    $actions .= "<a href='/admin/master/location/city/$row->id/delete' class='btn btn-danger btn-sm' ><span class='fa fa-trash'></span></a>";
                }

                return $actions;
            })
            ->rawColumns(['deleted_at', 'actions'])
            ->removeColumn('id')
            ->make();

    }

    public function getCities($stateId){
        if ($stateId) {
            $cityData = City::all()->where('state_id', '=', $stateId);
        }
        else {
            $cityData = City::all();
        }

        $cityDataArray = array();
        foreach ($cityData as $value) {
            $cityDataArray[$value->id] = $value->name;
        }
        
        return $cityDataArray;
    }

}
