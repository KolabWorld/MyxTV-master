<?php namespace App\Http\Controllers\Admin\Api;

use Session;

use App\User;
use App\Models\MailBox;
use App\Models\ServerWelcomeEmail;
use App\Models\SupportTicket;
use App\Models\SupportTicketComment;
use App\Models\SupportTicketAttachment;
use App\Models\Department;
use Illuminate\Http\Request;
use App\Helpers\ConstantHelper;
use App\Services\Mailers\Mailer;
use App\Http\Controllers\AdminController;

class SupportTicketController extends AdminController {
    public function __construct(){
        parent::__construct();
    }

    public function supportTickets($ticketId)
    {
        $auth = \Auth::user();
        $status = Session::get('status');
        $comments = SupportTicketComment::with(['admin','user'])
            ->where('ticket_id', '=', $ticketId)
            ->orderBy('id','ASC')
            ->get();

        return $comments;
    }

    public function addSupportTicket(Request $request) {

        $user = \Auth::user();

        $ticketComment = new SupportTicketComment();
        $ticketComment->ticket_id = $request->ticket_id;
        $ticketComment->admin_id = $user->id;
        $ticketComment->comment = $request->comment;
        $ticketComment->created_by = $user->id;
        $ticketComment->updated_by = $user->id;
        $ticketComment->save();
        $attachment = "";

        if($request->image)
        {
            // Create a new image from base64 string and attach it to ticketComment in image collection
          $mcol =  $ticketComment->addMediaFromBase64($request->image)
                ->toMediaCollection('image');

            // Get image as we will need the last one uploaded  $str = (new SupportTicket)->supportdepartmentusers();
            $image = $ticketComment->load('media')->getMedia('image');
            $attachment = env('APP_URL','').'/storage/'.$mcol->id.'/'.$mcol->file_name;
            // Replace the base64 string in article body with the url of the last uploaded image
            // $article->body = str_replace($image, $mediaItems[count($mediaItems) - 1]->getFullUrl(), $article->body);
        }

        $supportTicket = SupportTicket::with(['createdBy'])->find($ticketComment->ticket_id);

        $assignedTo = User::find($supportTicket->assigned_to);
        $createdBy = User::find($supportTicket->created_by);
        $createdByClient = User::find($supportTicket->user_id);
        $departmentemail = Department::where('id', $supportTicket->department_id)->first();
        $departmentemailid = "";
        if($departmentemail){
            $departmentemailid = $departmentemail->email;
        }
        $welcomeEmail = ServerWelcomeEmail::where('name', '=', 'Support Ticket Reply')
            ->first();
        $openWelcomeEmail = ServerWelcomeEmail::where('name', '=', 'Support Ticket Opened')
            ->first();

        $siteLink = "";
        $RECOMMENT = $request->comment;
    	if($attachment!=""){
    		$RECOMMENT = $request->comment."<br><a href=".$attachment." target='_blank'>Click here</a> to check attachment";
    	}

        if($welcomeEmail){
            $description = $welcomeEmail->description;
            $emailKeywords = array(
                "{TICKET_MESSAGE}" => 	$RECOMMENT,
                "{TICKET_ID}" => $supportTicket->ticket_number,
                "{TICKET_SUBJECT}" => $supportTicket->subject,
                "{TICKET_STATUS}" => $supportTicket->status,
                "{TICKET_LINK}" => $siteLink
            );
            foreach($emailKeywords as $key => $val){
                $description = str_replace("$key",$val, $description);
            }
 
        
            $mailbox = new MailBox;
            $mailbox->mail_cc =  $mailbox->mail_cc;
            // if($strEmail){
            //     $mailbox->mail_cc =  $mailbox->mail_cc.",".$strEmail;
            // }

            $mailArray = array(
                "name" => $assignedTo ? $assignedTo->name : $user->name,
                "mobile" => $assignedTo ? $assignedTo->mobile : $user->mobile,
                "email" => $assignedTo ? $assignedTo->email : $user->email,
                "email_template_name" => $welcomeEmail->name,
                "from_name" => $welcomeEmail->fromname,
                "from_email" => $welcomeEmail->fromemail,
                "subject" => $supportTicket->ticket_number. '::'. $openWelcomeEmail->subject,
                "copy_to" => $welcomeEmail->copyto,
                "description" => $description
            );

            $mailbox->mail_body = json_encode($mailArray);
            $mailbox->subject = $supportTicket->ticket_number. '::'. $openWelcomeEmail->subject;
            $mailbox->mail_to = $createdByClient ? $createdByClient->email : $createdBy->email;
            if($welcomeEmail->copyto){
                $mailbox->mail_cc = $welcomeEmail->copyto;
            }
            $mailbox->mail_cc .=	($departmentemailid!=""?",".$departmentemailid:"");
            $mailbox->mail_cc = trim($mailbox->mail_cc,",");
            
            $mailbox->category = $welcomeEmail->name;
            $mailbox->layout = "email.email-template";
            $mailbox->save();

            $mailer = new Mailer;
            $mailer->emailTo($mailbox);
        }

        return $ticketComment;
    }

}
