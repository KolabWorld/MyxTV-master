<?php

namespace App\Http\Controllers\Admin;

use DB;
use Auth;
use View;
use Input;
use Session;
use Datatables;
use Carbon\Carbon;

use App\User;
use App\Models\Department;

use Illuminate\Http\Request;
use App\Helpers\GeneralHelper;
use App\Http\Controllers\AdminController;

use App\Http\Requests\DepartmentRequest;

class DepartmentController extends AdminController
{
    public function __construct()
    {
        parent::__construct();
        View::share('menu_id', 'menu_admin');
        View::share('submenu_id', 'submenu_departments');
    }

    public function index()
    {
        $status = Session::get('status');
        return view('admin.department.index',  array('status' => $status));
    }

    public function create()
    {
        $department = new Department;

        return view(
            'admin.department.create_edit',
            array(
                'department' => $department
            )
        );
    }

    public function store(DepartmentRequest $request)
    {

        $department = new Department();
        $input = $request->all();

        $department->fill($input);
        $department->created_by = Auth::user()->id;
        $department->save();

        $status = array(
            'code' => 'success',
            'header' => 'Success',
            'messages' => array('department successfully created')
        );

        return '<script type="text/javascript">
            parent.jQuery.colorbox.close();
            </script>';
    }

    public function edit($id)
    {
        $status = Session::get('status');
        $department = Department::find($id);

        return view(
            'admin.department.create_edit',
            array(
                'department' => $department,
                'status' => $status
            )
        );
    }

    public function update(DepartmentRequest $request, $id)
    {

        $department = Department::find($id);
        $input = $request->all();

        $department->fill($input);
        $department->save();

        $status = array(
            'code' => 'success',
            'header' => 'Success',
            'messages' => array('department successfully edited')
        );

        return '<script type="text/javascript">
            parent.jQuery.colorbox.close();
            </script>';
    }

    public function delete($id)
    {
        $department = Department::find($id);

        if ($department->delete()) {
            $status = array(
                'code' => 'success',
                'header' => 'Success',
                'messages' => array('department  successfully deleted')
            );
        } else {
            $status = array(
                'code' => 'danger',
                'header' => 'Error',
                'messages' => array('Something went wrong, unable to delete requested department ')
            );
        }

        return redirect('admin/departments')->with('status', $status);
    }

    public function restore($id)
    {
        $department = Department::withTrashed()->find($id);

        if ($department->restore()) {
            $status = array(
                'code' => 'success',
                'header' => 'Success',
                'messages' => array('department successfully restored')
            );
        } else {
            $status = array(
                'code' => 'danger',
                'header' => 'Error',
                'messages' => array('Something went wrong, unable to delete requested department')
            );
        }

        return redirect('admin/departments')->with('status', $status);
    }

    public function data()
    {

        $groups = Department::withTrashed()->select('name', 'email', 'description', 'deleted_at', 'created_at',  'id');

        return Datatables::of($groups)
            ->editColumn('created_at', function ($row) {
                $x = "{$row->created_at}";
                return date('M d, Y h:i A', strtotime($x));
            })
            ->editColumn('deleted_at', function ($row) {
                if ($row->deleted_at) {
                    return '<span class=\'glyphicon glyphicon-remove\'></span> @endif';
                } else {
                    return '<span class="glyphicon glyphicon-ok"></span>';
                }
            })
            ->addColumn('actions', function ($row) {

                $actions = '';
                if ($row->deleted_at) {
                    $actions .= "<a href='/admin/department/$row->id/restore' class='btn btn-info btn-sm' ><span class='fa fa-refresh'></span></a>";
                } else {
                    $actions = "<a href='/admin/department/$row->id/edit' class='btn btn-success btn-sm pull-left iframe' ><span class='glyphicon glyphicon-pencil'></span></a>";

                    $actions .= "<a href='/admin/department/$row->id/delete' class='btn btn-danger btn-sm pull-left' ><span class='fa fa-trash'></span></a>";
                }

                return $actions;
            })
            ->rawColumns(['deleted_at', 'actions', 'description'])
            ->removeColumn('id')
            ->make();
    }
}