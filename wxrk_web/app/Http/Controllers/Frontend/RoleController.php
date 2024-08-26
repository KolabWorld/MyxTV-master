<?php namespace App\Http\Controllers\Admin;

use App\Helpers\ConstantHelper;
use Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\AdminController;
use App\Models\Permission;
use App\Models\Role;
use View;
use Session;
use Datatables;

class RoleController extends AdminController {
    public function __construct(){
        parent::__construct();
        View::share('menu_id','menu_groups');
        View::share('submenu_id','');
    }

    public function index()
    {
        $status = Session::get('status');
        return view('admin.role.index',  array('status' => $status));
    }

    public function getContacts($group_id){
        $status = Session::get('status');
        return view('admin.group.contacts',
            array(
                'group_id' => $group_id,
                'status' => $status
            )
        );
    }

    public function create()
    {
        $role = new Role;
        $permissions = Permission::all();
        $permissionsArray = array();

        foreach ($permissions as $permission) {
            if(!isset($permissionsArray[$permission->name])) {
                $permissionsArray[$permission->name] = array();
            }
            $permissionsArray[$permission->name][$permission->id] = $permission->type;

        }
        return view('admin.role.create_edit', array(
            'role' => $role,
            'permissions' => $permissionsArray,
            'rolePermissions' => []
        ));
    }

    public function store(Request $request) {

        $this->validate($request, [
            'name' => 'required|max:99|unique:roles',
            'alias' => 'required|max:99'
        ]);
        $role = new Role;
        $role->name = $request->name;
        $role->alias = $request->alias;
        $role->save();

        $permissions = array_keys($request->permission);

        $role->permissions()->sync($permissions);

        $status = array('code' => 'success',
            'header' => 'Success',
            'messages' => array('New Role successfully created')
        );

        return redirect('admin/role/'.$role->id.'/edit')->with('status', $status);
    }

    public function edit(Role $role)
    {
        $status = Session::get('status');
        $permissions = Permission::all();
        $permissionsArray = array();

        foreach ($permissions as $permission) {
            if(!isset($permissionsArray[$permission->name])) {
                $permissionsArray[$permission->name] = array();
            }
            $permissionsArray[$permission->name][$permission->id] = $permission->type;

        }

        return view('admin.role.create_edit', array(
            'status' => $status,
            'role' => $role,
            'permissions' => $permissionsArray,
            'rolePermissions' => $role->permissions->pluck('id')->toArray()
        ));
    }
    public function update(Request $request, $role) {
    $id= $role->id;
	$request->request->add(['id' => $id]);
        $this->validate($request, [
            'name' => 'required|max:99',
            'alias' => 'required|max:99'
        ]);//echo $request->id;exit;
        $role = Role::find($id);
        $role->name = $request->name;
        $role->alias = $request->alias;
        $role->save();
        $permissions = array();
        if(is_array($request->permission))
            $permissions = array_keys($request->permission);

        $role->permissions()->sync($permissions);

        $status = array('code' => 'success',
                'header' => 'Success',
                'messages' => array('New group successfully edited')
                );

        return redirect('admin/role/'.$role->id.'/edit')->with('status', $status);
    }
    public function postEdit(Request $request, $id) {

        $group = Groups::find($id);
        $group->name = $request->name;
        $group->description = $request->description;
        $group->save();

        $status = array('code' => 'success',
                'header' => 'Success',
                'messages' => array('New group successfully edited')
                );

        return redirect('admin/group/'.$group->id.'/edit')->with('status', $status);
    }

    public function delete($role) {
        if($role->delete()) {
            $status = array('code' => 'success',
                'header' => 'Success',
                'messages' => array('Role successfully deleted')
            );
        } else {
            $status = array('code' => 'danger',
                'header' => 'Error',
                'messages' => array('Something went wrong, unable to delete requested group')
            );
        }

        return redirect('admin/roles')->with('status', $status);
    }

    public function restore($id) {
        $role = Role::withTrashed()->find($id);

        if($role->restore()) {
            $status = array('code' => 'success',
                'header' => 'Success',
                'messages' => array('Role successfully restored')
            );
        } else {
            $status = array('code' => 'danger',
                'header' => 'Error',
                'messages' => array('Something went wrong, unable to delete requested role')
            );
        }

        return redirect('admin/roles')->with('status', $status);
    }


    public function data()
    {

        $roles = Role::select('name','alias', 'deleted_at', 'created_at',  'id')
            ->withTrashed();

        return Datatables::of($roles)
            ->editColumn('created_at', function($row) {
                    $x = "{$row->created_at}";
                    return date('M d, Y h:i A',strtotime($x));
                })
            ->editColumn('deleted_at', function($row) {
                if($row->deleted_at==NULL)
                    return '<span class="glyphicon glyphicon-ok"></span>';
                else
                    return '<span class=\'glyphicon glyphicon-remove\'></span>';

            })
            ->addColumn('actions', function($row) {

                $actions = '';
                if ($row->deleted_at) {
                    $actions .= "<a href='/admin/role/$row->id/restore' class='btn btn-success btn-sm' ><span class='fa fa-refresh'></span> Restore</a>";
                }
                else if($row->alias !== ConstantHelper::ROLE_ADMIN) {
                    $actions = "<a href='/admin/role/$row->id/edit' class='btn btn-success btn-sm pull-left' ><span class='glyphicon glyphicon-pencil'></span></a>";
                    $actions .= "<a href='/admin/role/$row->id/delete' class='btn btn-danger btn-sm pull-left' ><span class='fa fa-trash'></span></a>";
                }

                return $actions;
            })
            ->removeColumn('id')
            ->rawColumns(['actions', 'deleted_at', 'created_at'])
            ->make();

    }

}
