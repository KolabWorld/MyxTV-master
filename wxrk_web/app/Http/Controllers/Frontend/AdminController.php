<?php
namespace App\Http\Controllers\Frontend;

use Auth;

use App\Models\Role;
use App\Models\Admin;
use App\Models\AdminRole;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;

use App\Models\MailBox;
use App\Services\Mailers\Mailer;

use Illuminate\Validation\ValidationException;
use App\Lib\Validation\Admin as Validator;

class AdminController extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index(Request $request, $type)
    {
        $role = 'admin';
        $records = Admin::orderBy('id', 'ASC');
        
        if($type == 'contractors'){
            $role = 'contractor';
            $records = $records->where('admin_type', '=', 'contractor');

            if ($request->company_name){
                $records = $records->where('company_name', '=', $request->company_name);
            }

        }
        else{
            $records = $records->where('admin_type', '=', 'admin')
                ->where('user_name', '!=', 'admin');
        }
        
        if ($request->status) {
            $records->where('status','=',$request->status);
        }
        
        if ($request->search) {
            $records->where(function($query) use ($request){
                $query->where('name', 'like', '%' . $request->search . '%')
                    ->orWhere('email', 'like', '%' . $request->search . '%')
                    ->orWhere('mobile','like', '%' . $request->search . '%')
                    ->orWhere('company_name','like', '%' . $request->search . '%');
            });
        }

        $records = $records->paginate(10);
        // $records = $records->get();
        // return $records;

        return view('frontend.admin.index', [
            'tab' => $type,
            'role' => $role,
            'type' => $type,
            'records' => $records,
        ]);
    }

    public function show()
    {
        return view('frontend.admin.index');
    }

    public function create(Request $request, $type)
    {
        $role = 'admin';  
        $admin = new Admin();
        $roles = Role::orderBy('name', 'ASC');
        if($type == 'contractors'){
            $role = 'subcontractor';
            $roles = $roles->where('alias', '=', 'contractor');
        }
        else{
            $roles = $roles->whereNotIn('alias', ['contractor','admin','operator']);
        }
        $roles = $roles->get();
        
        return view(
            'frontend.admin.create',
            array(
                'tab' => $type,
                'role' => $role,
                'type' => $type,
                'admin' => $admin,
                'roles' => $roles,
            )
        );
    }

    public function store(Request $request, $type)
    {
        $auth = \Auth::user();
        $validator = (new Validator($request))->store();
		
        if($validator->fails()){
			throw new ValidationException($validator);
		}

        $adminData = new Admin();
        $adminData->fill($request->all());
        $adminData->user_name = $request->email;
        if($request->admin_type == 'contractors'){
            $adminData->admin_type = 'contractor';
        }
        else{
            $adminData->admin_type = 'admin';
        }
        $adminData->is_email_verified = 1;
        $adminData->remember_token = bcrypt(Str::random(6));;
        $adminData->created_by = $auth->id;
        $adminData->save();

        $adminData->roles()->sync($request->admin_roles);

        if ($adminData->email) {
            $mailbox = new MailBox;

            $email = $adminData->email;
            // $name = $bpMaster->full_name;
            $description = 'Dear '.$adminData->name.'!<br/>
            <br/>
            You have been registered on the Portal. Please click below button to set your password for your account.<br/>
            <a href="'.config('app.url').'/reset-password?token='.$adminData->remember_token.'" class="btn-primary" itemprop="url" style="font-family: Helvetica Neue,Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; color: #FFF; text-decoration: none; line-height: 2em; font-weight: bold; text-align: center; cursor: pointer; display: inline-block; border-radius: 5px; text-transform: capitalize; background-color: #f06292; margin: 0; border-color: #f06292; border-style: solid; border-width: 8px 16px;">Set Password</a>
            <br/>
            Thanks<br/>
            Samsung Engineering';

            $mailSubject = "Account Created";

            $mailArray = array(
                "header" => "Account Created",
                "description" => $description,
                "mailSubject" => $mailSubject,
                "footer" => "System Generated Email"
            );

            $mailbox->mail_body = $mailArray;
            $mailbox->category = "Account Created";
            $mailbox->mail_to = $email;
            $mailbox->subject = "Account Created";
            $mailbox->layout = "email.email-template";
            $mailbox->save();	

            $mailer = new Mailer;
            $mailer->emailTo($mailbox);
        }

        return redirect('/main/'.$type)->with(['success' => 'Record added succesfully']);
    }

    public function edit($type, $id)
    {
        $admin = Admin::find($id);
        $role = 'admin';
        $roles = Role::orderBy('name', 'ASC');
        if($type == 'contractors'){
            $role = 'contractor';
            $roles = $roles->where('alias', '=', 'contractor');
        }
        else{
            $roles = $roles->whereNotIn('alias', ['contractor','admin','operator']);
        }
        $roles = $roles->get();
        $adminRoles = $admin->roles->pluck('id')->toArray();
        return view(
            'frontend.admin.edit',
            array(
                'tab' => $type,
                'role' => $role,
                'type' => $type,
                'admin' => $admin,
                'adminRoles' => $adminRoles,
                'roles' => $roles,
            )
        );
    }

    public function update(Request $request, $type, $id)
    {
        $auth = \Auth::user();
        
        $request->request->add(['id' => $id]);
		$validator = (new Validator($request))->update();
        if($validator->fails()){
            throw new ValidationException($validator);
		}

        $adminData = Admin::find($id);
        $adminData->fill($request->all());
        $adminData->updated_by = $auth->id;

        $adminData->update();

        $adminData->roles()->sync($request->admin_roles);

        return redirect('/main/'.$type)->with(['success' => 'Record updated succesfully']);
    }

    public function destroy($type, $id)
    {
        $admin = Admin::with(['roles'])->find($id);

        if($admin){
            if($admin->roles && (count($admin->roles) > 0)){
                return [
                    'message' => "Please delete all the mappings for this record, after that you can delete this record!",
                ];
            }
            else{
                $admin->status = 'inactive';
                $admin->save();
                $admin->delete();

                return [
                    'message' => "Record deleted successfully!"
                ];
            }
        }
        else{
            return [
                'message' => "Record does not exist!"
            ];
        }
    }
}