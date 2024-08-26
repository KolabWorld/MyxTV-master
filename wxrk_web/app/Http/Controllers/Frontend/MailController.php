<?php namespace App\Http\Controllers\Admin;

use App\Http\Controllers\AdminController;
use Auth;
use Datatables;
use Illuminate\Http\Request;
use App\Helpers\GeneralHelper;
use App\Services\Mailers\Mailer;
use DB;
use Input;
use View;
use Session;
use App\User;
use App\Models\Groups;
use App\Models\Contacts;
use App\Models\MailBox;

class MailController extends AdminController {

    const QUEUE_NAME = 'aims-email';

    public function __construct(){
        parent::__construct();

        View::share('menu_id','menu_mail');
        View::share('submenu_id','');
    }

    public function index() {
        
        $status = Session::get('status');
        return view('admin.mail.index', array('status' => $status));
    }

    public function sentBox() {
        
        $status = Session::get('status');

        $mails = MailBox::orderBy('id', 'DESC')
                            ->get();

        return view('admin.mail.sent', array('status' => $status, 'mails' => $mails));
    }

    public function viewMail($id) {
        
        $status = Session::get('status');

        $mail = MailBox::find($id);

        return view('admin.mail.view', array('status' => $status, 'mail' => $mail));
    }

 
    public function compose($type, $id) {

        if ($type == 'group') {
            $group = Groups::find($id);

            if ($group) {
                $emailTo = $group->name;
            }
        }
        else if ($type == 'contact') {
            $contact = Contacts::find($id);
            if ($contact) {
                $emailTo = $contact->email;
            }
        }

        if (!$emailTo) {
            $status = array('code' => 'danger',
                    'header' => 'Error',
                    'messages' => array('No reciever found')
                );
            return redirect('admin/mail/sent')->with('status', $status);
        }

        return view('admin.mail.compose', array('emailTo' => $emailTo));
    }

    public function sendMail(Request $request, $type, $id) {

        if ($type == 'group') {
            $group = Groups::find($id);

            if(!$group) {
                $status = array('code' => 'danger',
                    'header' => 'Error',
                    'messages' => array('No record found')
                );
                return redirect('admin/mail/sent')->with('status', $status);
            }
            $contacts = $group->contacts;

            if (!$contacts) {
                $status = array('code' => 'danger',
                    'header' => 'Error',
                    'messages' => array('No contacts record found')
                );
                return redirect('admin/mail/sent')->with('status', $status);
            }

            foreach ($contacts as $contact) {
                $mailBox = new MailBox;
                $contact = $contact->contact;
                $mailBox->contact_id = $contact->id;
                $mailBox->mail_to = $contact->email;
                $mailBox->subject = $request->subject;
                $mailBox->mail_text = $request->mail;
                $mailBox->layout = 'email.generic-plain-text';
                $mailBox->type = 'group';
                if (!$mailBox->save()) {
                    // handle error here
                }
            }
            
        }
        else if ($type == 'contact') {
            $contact = Contacts::find($id);
            $mailBox = new MailBox;

            $mailBox->contact_id = $contact->id;
            $mailBox->mail_to = $contact->email;
            $mailBox->subject = $request->subject;
            $mailBox->mail_text = $request->mail;
            $mailBox->layout = 'email.generic-plain-text';
            $mailBox->type = 'contact';
            if (!$mailBox->save()) {
                // handel error here
            }

            $this->cron($mailBox->id);
        }

        $status = array('code' => 'success',
            'header' => 'Success',
            'messages' => array('Email successfully queued')
        );
        return redirect('admin/mail/sent')->with('status', $status);
    }

    public function cron($id = 0) {

        if ($id) {
            $mailbox = MailBox::find($id);
        }
        else {
            $mailbox = MailBox::where('status', '=', MailBox::STATUS_PENDING)->first();
        }
        if (!$mailbox) {
            echo 'no pending mail found';
            return false;
        }
        $subject = $mailbox->subject;
        $data['message'] = $mailbox->mail_text;
        $data['id'] = $mailbox->id;

        $to = $mailbox->mail_to;
        $view = $mailbox->layout;
        
        $mailer = new Mailer;
        $resp = $mailer->emailTo(self::QUEUE_NAME, $to, $view, $data, $subject);
        
        return $resp;
    }

    public function data()
    {

        $mails = MailBox::select('star','contacts.name','subject','status', 'mail_box.created_at','mail_box.id')
                    ->join('contacts', 'contacts.id', '=', 'mail_box.contact_id')
                    ->orderBy('id', 'DESC');

        return Datatables::of($mails)
            ->editColumn('created_at', function($row) {
                $x = "{$row->created_at}";
                return date('M d, Y h:i A',strtotime($x));
            })
            ->editColumn('name', function($row) {
                return "<a href='/admin/mail/$row->id/view'>" . $row->name ."</a>";
            })
            ->editColumn('star', function($row) {
                return '<i class="fa fa-star text-yellow"></i>';
            })
            ->editColumn('status', function($row){

                if ($row->status == MailBox::STATUS_REJECTED) {
                    return ' <small class="label pull-right bg-red">Rejected</small>';
                }
                else if($row->status == MailBox::STATUS_COMPLETED) {
                    return '<small class="label pull-right bg-green">Sent</small>';
                }
                else {
                    return '<small class="label pull-right bg-yellow">Pending</small>';
                }
            })
            ->removeColumn('id')
            ->make();
    }
}
