<?php
namespace App\Helpers;

use App\Models\MailBox;
use App\Models\ServerWelcomeEmail;
use App\Services\Mailers\Mailer;
use App\Models\SupportTicket;
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
*/

Class MailHelper {

    // send sms to user
	public static function newSupportTickert($user, $supportTicket)
	{

        $welcomeEmail = ServerWelcomeEmail::where('name', '=', 'Support Ticket Opened')
            ->first();

        if(!$welcomeEmail){
            return false;
        }

        $siteLink = "<a href='".env('APP_URL', '')."'>Miditech</a>";    
        
        $description = $welcomeEmail->description;
        $emailKeywords = array(
            "{CLIENT_NAME}" => $user->name,
            "{TICKET_SUBJECT}" => $supportTicket->subject,
            "{TICKET_PRIORITY}" => $supportTicket->priority,
            "{TICKET_STATUS}" => $supportTicket->status,
			"{TICKET_DESCIPTION}" => $supportTicket->message,
            "{TICKET_ID}" => $supportTicket->ticket_number,
            "{TICKET_LINK}" => $siteLink,
            "{SIGNATURE}" => ""
        );
        foreach($emailKeywords as $key => $val){
            $description = str_replace("$key",$val, $description);
        }

        $mailbox = new MailBox;

        $mailArray = array(
            "name" => $user->name,
            "mobile" => $user->mobile,
            "email" => $user->email,
            "email_template_name" => $welcomeEmail->name,
            "from_name" => $welcomeEmail->fromname,
            "from_email" => $welcomeEmail->fromemail,
            "subject" => $welcomeEmail->subject,
            "copy_to" => $welcomeEmail->copyto,
            "description" => $description
        );

        $mailbox->mail_body = json_encode($mailArray);
        $mailbox->subject = $supportTicket->ticket_number . "::". $welcomeEmail->subject;
        $mailbox->mail_to = $user->email;
        if($welcomeEmail->copyto){
            $mailbox->mail_cc = $welcomeEmail->copyto;
        }
        $strEmail = (new SupportTicket)->supportdepartmentusers();
        if( $strEmail){
            $mailbox->mail_cc =  $mailbox->mail_cc.",".$strEmail;
        }
        $mailbox->category = $welcomeEmail->name;
        $mailbox->layout = "email.email-template";
        $mailbox->save();

        $mailer = new Mailer;
        $mailer->emailTo($mailbox);

        return true;
    }
}
