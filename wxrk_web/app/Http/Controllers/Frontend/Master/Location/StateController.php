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
use App\Models\State;

use Illuminate\Http\Request;
use App\Helpers\GeneralHelper;
use App\Http\Controllers\AdminController;

use Illuminate\Validation\ValidationException;
use App\Lib\Validation\LocationMaster as Validator;

class StateController extends AdminController {
    public function __construct(){
        parent::__construct();
        View::share('menu_id','menu_master');
        View::share('submenu_id','submenu_states');
    }

    public function index()
    {
        $status = Session::get('status');

        $records = State::paginate(10);

        return view('frontend.master.location.state.index',  array(
            'tab' => 'states',
            'status' => $status,
            'records' => $records,
        ));
    }

    public function create()
    {
        $countries = Country::all();
        $state = new State();
        return view('frontend.master.location.state.create_edit',
            array(
                'state' => $state,
                'countries' => $countries,
            )
        );
    }

    public function store(Request $request) {
        $auth = \Auth::user();
		$status = array();
		$validator = (new Validator($request))->storeState();

		if($validator->fails()){
			throw new ValidationException($validator);
        }

        $state = new State();
        $input = $request->all();
        $state->fill($input);
        $state->save();

        $status = array('code' => 'success',
            'header' => 'Success',
            'messages' => array('New state successfully created')
        );

        return '<script type="text/javascript">
            parent.jQuery.colorbox.close();
            </script>';
    }

    public function edit($id)
    {
        $status = Session::get('status');
        $countries = Country::all();
        $state = State::find($id);

        return view('frontend.master.location.state.create_edit',
            array(
                'countries' => $countries,
                'state' => $state,
                'status' => $status
            )
        );
    }

    public function update(Request $request, $id) {
        $auth = \Auth::user();
		$status = array();
		$request->request->add(['id' => $id]);
		$validator = (new Validator($request))->updateState();

		if($validator->fails()){
            throw new ValidationException($validator);
        }

        $state = State::find($id);
        $input = $request->all();
        $state->fill($input);
        $state->save();

        $status = array('code' => 'success',
                'header' => 'Success',
                'messages' => array('New state successfully edited')
                );

        return '<script type="text/javascript">
            parent.jQuery.colorbox.close();
            </script>';
    }

    public function delete($id) {
        $state = State::find($id);

        if($state->delete()) {
            $status = array('code' => 'success',
                'header' => 'Success',
                'messages' => array('state successfully deleted')
            );
        } else {
            $status = array('code' => 'danger',
                'header' => 'Error',
                'messages' => array('Something went wrong, unable to delete requested state')
            );
        }

        return redirect('admin/master/location/states')->with('status', $status);
    }

    public function restore($id) {
        $state = State::withTrashed()->find($id);

        if($state->restore()) {
            $status = array('code' => 'success',
                'header' => 'Success',
                'messages' => array('state successfully restored')
            );
        } else {
            $status = array('code' => 'danger',
                'header' => 'Error',
                'messages' => array('Something went wrong, unable to delete requested state')
            );
        }

        return redirect('admin/master/location/states')->with('status', $status);
    }

    public function data()
    {

        $states = State::withTrashed()->select(
            'name',
            'country_id',
            'deleted_at',
            'created_at',
            'id'
        )
        ->with('country')
        ->orderBy('created_at','DESC');

        return Datatables::of($states)
            ->editColumn('country_id', function($row) {
                $x = $row->country->name;
                return $x;
            })
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
                    $actions .= "<a href='/admin/master/location/state/$row->id/restore' class='btn btn-info btn-sm' ><span class='fa fa-refresh'></span></a>";
                }
                else {
                    $actions = "<a href='/admin/master/location/state/$row->id/edit' class='btn btn-success btn-sm iframe' ><span class='glyphicon glyphicon-pencil'></span></a>";

                    $actions .= "<a href='/admin/master/location/state/$row->id/delete' class='btn btn-danger btn-sm' ><span class='fa fa-trash'></span></a>";
                }

                return $actions;
            })
            ->rawColumns(['deleted_at', 'actions', 'country_id'])
            ->removeColumn('id')
            ->removeColumn('country')
            ->make();

    }

    public function getStates($countryId){
        if ($countryId) {
            $stateData = State::all()->where('country_id', '=', $countryId);
        }
        else {
            $stateData = State::all();
        }

        $stateDataArray = array();
        foreach ($stateData as $value) {
            $stateDataArray[$value->id] = $value->name;
        }

        return $stateDataArray;
    }

}
