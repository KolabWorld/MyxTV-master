<?php 
namespace App\Http\Controllers\Admin;

use Auth;
use Datatables;
use Illuminate\Http\Request;
use App\Http\Controllers\AdminController;
use DB;
use Input;
use View;
use Session;
use File;
use Excel;
use App\Models\Groups;
use App\Models\Contacts;
use App\Models\GroupContacts;

class ContactController extends AdminController {
   
	public function __construct(){
		parent::__construct();
		View::share('menu_id','menu_contacts');
		View::share('submenu_id','');
	}

	/*
	* Display a listing of the resource.
	*
	* @return Response
	*/
	
	public function index(){
		$status = Session::get('status');
		return view('admin.contact.index',
			array(
				'status' => $status
			)
		);
	}

	public function getCreate($group_id = 0) {
		$status = Session::get('status');
		return view('admin.contact.create_edit',
				array(
					'status' => $status,
					'group_id' => $group_id
				)
			);
	}

	public function postCreate(Request $request, $group_id = 0){

		$contact = Contacts::withTrashed()
					->where('email','=',$request->email)
					->where('name','=',$request->name)
					->where('phone','=',$request->phone)
					->first();

		if(!$contact) {
			$contact = New Contacts();
			$contact->name = $request->name;
			$contact->email = $request->email;
			$contact->phone = $request->phone;
			$contact->address = $request->address;
			$contact->save();
		} else if($contact->deleted_at) {
			$contact->restore();
		}

		if ($group_id) {

			$groupContact = GroupContacts::where('group_id', $group_id)
								->where('contact_id', $contact->id)
								->first();
			if (!$groupContact) {
				$groupContact = new GroupContacts();
				$groupContact->group_id = $group_id;
				$groupContact->contact_id = $contact->id;
				$groupContact->save();
			}
		}

		$status = array(
			'code' => 'success',
			'header' => 'Success',
			'messages' => array('New Contact successfully created')
		);
		return redirect('admin/contact/'.$contact->id.'/edit')->with('status', $status);

	}

	public function getEdit($id) {
		$status = Session::get('status');
		$contact = Contacts::find($id);

		return view('admin.contact.create_edit',
			array(
				'contact' => $contact,
				'status' => $status
			)
		);
	}

	public function downloadSample() {
		ob_clean();
		$columnHeader = array(
		'Name',
		'Email Id',
		'Contact No',
		'Address'        
		);
		$filename = "sampleFile.csv";
		header( 'Content-Type: text/csv' );
		header( 'Content-Disposition: attachment;filename='.$filename);
		$fp = fopen('php://output', 'w');
		fputcsv($fp, $columnHeader);
		
		fclose($fp);
	}

	public function postEdit(Request $request, $id){

		$contact = Contacts::find($id);
		$contact->name = $request->name;
		$contact->email = $request->email;
		$contact->phone = $request->phone;
		$contact->address = $request->address;
		$contact->save();

		$status = array('code' => 'success',
						'header' => 'Success',
						'messages' => array('Contact successfully edited')
						);
		return redirect('admin/contact/'.$contact->id.'/edit')->with('status', $status);
	}

 	public function delete($id) {
        $contact = Contacts::find($id);

        if($contact->delete()) {
            $status = array('code' => 'success',
                'header' => 'Success',
                'messages' => array('Contact successfully deleted')
            );
        } else {
            $status = array('code' => 'danger',
                'header' => 'Error',
                'messages' => array('Something went wrong, unable to delete requested contact')
            );
        }
        
        return redirect('admin/contacts')->with('status', $status);
    }

    public function restore($id) {
        $contact = Contacts::onlyTrashed()->find($id);

        if($contact->restore()) {
            $status = array('code' => 'success',
                'header' => 'Success',
                'messages' => array('Contact successfully restored')
            );
        } else {
            $status = array('code' => 'danger',
                'header' => 'Error',
                'messages' => array('Something went wrong, unable to restore requested contact')
            );
        }
        
        return redirect('admin/contacts')->with('status', $status);
    }

    public function groupContactDelete($group_id, $id) {
        $contact = GroupContacts::find($id);

        if($contact->delete()) {
            $status = array('code' => 'success',
                'header' => 'Success',
                'messages' => array('Group contact successfully deleted')
            );
        } else {
            $status = array('code' => 'danger',
                'header' => 'Error',
                'messages' => array('Something went wrong, unable to delete requested group contact')
            );
        }
        
        return redirect('admin/'.$group_id.'/contacts')->with('status', $status);
    }

 	public function uploadContacts(Request $request, $group_id = 0) {
	   
		$csvFile =$_FILES['file']['tmp_name'];

		$file_handle = fopen($csvFile, 'r');

		// saving all rows of csv file in array
		while (!feof($file_handle) ) {
			$line_of_text[] = fgetcsv($file_handle, 1024);
		}

		foreach ($line_of_text as $key => $value) {
			if ($key) {
				$name = $value[0];
				$email = $value[1];
				$phone = $value[2];
				$address = $value[3];
				if ($email && $name) {

					$contact = Contacts::withTrashed()->where('email','=',$email)->first();

					if(!$contact) {
						$contact = New Contacts();
						$contact->name = $name;
						$contact->email = $email;
						$contact->phone = $phone;
						$contact->address = $address;
						$contact->save();
					} else if($contact->deleted_at) {
						$contact->restore();
					}
					if ($group_id) {
						$groupContact = GroupContacts::where('group_id', $group_id)
								->where('contact_id', $contact->id)
								->first();
						if (!$groupContact) {
							$groupContact = new GroupContacts();
							$groupContact->group_id = $group_id;
							$groupContact->contact_id = $contact->id;
							$groupContact->save();
						}
					}
				}
				
			}
		}

		fclose($file_handle);

		$status = array('code' => 'success',
						'header' => 'Success',
						'messages' => array('Contact successfully added')
					);
		return redirect('admin/'.$group_id.'/contacts')->with('status', $status);
	}

	public function groupContactData($group_id)
	{

		$variables = GroupContacts::select('contacts.name','contacts.email','contacts.phone','contacts.address', 'contacts.created_at', 'group_contacts.group_id','group_contacts.contact_id', 'group_contacts.id')->leftJoin('contacts','contacts.id','=','group_contacts.contact_id')->where('group_contacts.group_id','=', $group_id);

		return Datatables::of($variables)
			->editColumn('created_at', function($row) {
					$x = "{$row->created_at}";
					return date('M d, Y h:i A',strtotime($x));
				})
			->addColumn("actions", function($row) {

				$actions =  "<a href='/admin/contact/$row->contact_id/edit' class='btn btn-success btn-sm iframe' ><span class='glyphicon glyphicon-pencil'></span>  Edit</a>";
				$actions .= "<a href='/admin/$row->group_id/contact/$row->id/delete' class='btn btn-danger btn-sm' ><span class='fa fa-trash'></span>  Delete</a>";
				return $actions;
			})
			->removeColumn('id')
			->removeColumn('group_id')
			->removeColumn('contact_id')
			->make();
	}

	public function data()
	{

		$variables = Contacts::withTrashed()->select('name','email','phone','address', 'deleted_at', 'created_at','id');

		return Datatables::of($variables)
			->editColumn('created_at', function($row) {
				$x = "{$row->created_at}";
				return date('M d, Y h:i A',strtotime($x));
			})
			->editColumn('deleted_at', '@if ($deleted_at==NULL) <span class="glyphicon glyphicon-ok"></span> @else <span class=\'glyphicon glyphicon-remove\'></span> @endif')
			->addColumn("actions", function($row) {

				$actions = '';
				if ($row->deleted_at) {
					$actions .= "<a href='/admin/contact/$row->id/restore' class='btn btn-success btn-sm' ><span class='fa fa-refresh'></span> Restore</a>";
				}
				else {
					$actions = "<a href='/admin/contact/$row->id/edit' class='btn btn-success btn-sm iframe' ><span class='glyphicon glyphicon-pencil'></span>  Edit</a>";

					$actions .= "<a href='/admin/contact/$row->id/delete' class='btn btn-danger btn-sm' ><span class='fa fa-trash'></span>  Delete</a>";
					$actions .= "<a href='/admin/contact/$row->id/mail/compose' class='btn btn-info btn-sm' ><span class='fa fa-send'></span>  Send Email</a>";
				}
				return $actions;
			})
			->removeColumn('id')
			->make();
	}

}