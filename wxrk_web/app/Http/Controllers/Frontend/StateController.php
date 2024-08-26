<?php namespace App\Http\Controllers\Admin;

use Auth;
use App\Helpers\GeneralHelper;
use Illuminate\Http\Request;
use App\Http\Controllers\AdminController;
use DB;
use Carbon\Carbon;
use Input;
use View;
use Session;
use Datatables;
use App\User;
use App\Models\States;

class StateController extends AdminController {
    public function __construct(){
        parent::__construct();
        View::share('menu_id','menu_invoices');
        View::share('submenu_id','submenu_states');
    }

    public function index()
    {
        $status = Session::get('status');
        return view('admin.state.index',  array('status' => $status));
    }

    public function create()
    {
        $state = new States;
        return view('admin.state.create_edit',
            array(
                'state' => $state
            )
        );
    }

    public function store(Request $request) {

        $state = new States();
        $state->name = $request->name;
        $state->alias = $request->alias;
        $state->code = $request->code;
        $state->save();

        $status = array('code' => 'success',
            'header' => 'Success',
            'messages' => array('New state successfully created')
        );
        
        return redirect('admin/state/'.$state->id.'/edit')->with('status', $status);
    }

    public function edit($id)
    {
        $status = Session::get('status');
        $state = States::find($id);

        return view('admin.state.create_edit', array('state' => $state, 'status' => $status));
    }

    public function update(Request $request, $id) {

        $state = States::find($id);
        $state->name = $request->name;
        $state->alias = $request->alias;
        $state->code = $request->code;
        $state->save();

        $status = array('code' => 'success',
                'header' => 'Success',
                'messages' => array('New state successfully edited')
                );
        
        return redirect('admin/state/'.$state->id.'/edit')->with('status', $status);
    }

    public function delete($id) {
        $state = States::find($id);

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
        
        return redirect('admin/states')->with('status', $status);
    }

    public function restore($id) {
        $state = States::withTrashed()->find($id);

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
        
        return redirect('admin/states')->with('status', $status);
    }

    public function data()
    {

        $groups = States::withTrashed()->select('name','alias', 'code', 'deleted_at', 'created_at',  'id');

        return Datatables::of($groups)
            ->editColumn('created_at', function($row) {
                    $x = "{$row->created_at}";
                    return date('M d, Y h:i A',strtotime($x));
                })
            ->editColumn('deleted_at', '@if ($deleted_at==NULL) <span class="glyphicon glyphicon-ok"></span> @else <span class=\'glyphicon glyphicon-remove\'></span> @endif')
            ->addColumn('actions', function($row) {

                $actions = '';
                if ($row->deleted_at) {
                    $actions .= "<a href='/admin/state/$row->id/restore' class='btn btn-info btn-sm' ><span class='fa fa-refresh'></span> Restore</a>";
                }
                else {
                    $actions = "<a href='/admin/state/$row->id/edit' class='btn btn-success btn-sm pull-left iframe' ><span class='glyphicon glyphicon-pencil'></span>  Edit</a>";

                    $actions .= "<a href='/admin/state/$row->id/delete' class='btn btn-danger btn-sm pull-left' ><span class='fa fa-trash'></span>  Delete</a>";
                }

                return $actions;
            })
            ->removeColumn('id')
            ->make();

    }
   
}
        
