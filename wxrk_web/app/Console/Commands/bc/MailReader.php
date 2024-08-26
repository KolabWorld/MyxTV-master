<?php

namespace App\Console\Commands\bc;

use App\User;
use App\Models\Department;
use App\Models\SupportTicket;
use App\Models\SupportTicketComment;

use App\Helpers\MailHelper;
use Illuminate\Console\Command;
use Webklex\IMAP\Facades\Client;

class MailReader extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'mail:read';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Email Read from inbox';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {

        try {
            $oClient = Client::account('support');
            $oClient->connect();
            $oFolder = $oClient->getFolder("INBOX");

            if (!$oFolder) {
                die('end no data');
            }
            $messages =  $oFolder->query()->unseen()->since(now()->subDays(1))->get();
            //echo "<pre>";print_r($messages);exit;

            foreach ($messages as $oMessage) { //echo "<pre>";print_r($oMessage->x_ham_report);exit;
                $htmlContent = "";
                if (isset($oMessage->bodies['html']))
                    $htmlContent = $oMessage->bodies['html'];
                if (isset($oMessage->x_ham_report[5]))
                    $htmlContent = $oMessage->x_ham_report[5];
                if ($htmlContent != "") {
                    $htmlContent = str_replace("Content preview:", "", $htmlContent);
                    $htmlContent = str_replace("Miditech Support wrote:", "", $htmlContent);
                    $emailId = $oMessage->getFrom()[0]->mail;
                    // echo  $oMessage->getUid() . " from : ".   $emailId ;
                    // echo  "Subject : ".   $oMessage->getSubject() ;
                    // echo '\n';
                    // continue;
                    if ($emailId == "support@miditech.co.in")
                        continue;
                    $user = User::where('email', '=', $emailId)
                        ->first();

                    if (!$user) {
                        continue;
                    }

                    $emailUid = $oMessage->getUid();

                    $supportTicket = SupportTicket::where('email_uid', '=', $emailUid)
                        ->first();
                    //echo "<pre>";print_r($supportTicket);
                    if ($supportTicket) {
                        continue;
                    }

                    $ticketComment = SupportTicketComment::where('email_uid', '=', $emailUid)
                        ->first();

                    if ($ticketComment) {
                        continue;
                    }


                    $subject = $oMessage->getSubject();

                    $pos = strpos($subject, '#MT');
                    if ($pos !== false) {
                        $ticketNumber = substr($subject, strpos($subject, '#MT'), 10);

                        $supportTicket = SupportTicket::where('ticket_number', '=', $ticketNumber)
                            ->first();

                        if ($supportTicket) {
                            $ticketComment = new SupportTicketComment();
                            $ticketComment->ticket_id = $supportTicket->id;
                            // $ticketComment->comment = $oMessage->getHTMLBody();
                            $ticketComment->user_id = $user->id;
                            $ticketComment->comment = $htmlContent;
                            $ticketComment->email_uid = $emailUid;
                            $ticketComment->save();

                            // $oMessage->getAttachments()->each(function ($oAttachment) use ($supportTicket) {
                            //     dd($oAttachment);
                            //     $supportTicket->addMedia($oAttachment)->toMediaCollection('attachments');
                            // });
                            $supportTicket->status = "Open";

                            $supportTicket->save();
                            continue;
                        }
                    }

                    $randomNumber = rand(1000000, 10000000);
                    $ticketNumber = '#MT' . $randomNumber;

                    $department = Department::first();
                    if (isset($oMessage->bodies['html']))
                        $htmlContent = $oMessage->bodies['html'];
                    if (isset($oMessage->x_ham_report[5]))
                        $htmlContent = $oMessage->x_ham_report[5];
                    $htmlContent = str_replace("Content preview:", "", $htmlContent);
                    $htmlContent = str_replace("Miditech Support wrote:", "", $htmlContent); //echo $htmlContent;exit;
                    $supportTicket = new SupportTicket();
                    $supportTicket->subject = $oMessage->getSubject();
                    $supportTicket->department_id = $department->id;
                    $supportTicket->user_id = $user->id;
                    $supportTicket->priority = "medium";
                    $supportTicket->email_uid = $emailUid;
                    $supportTicket->ticket_number = $ticketNumber;
                    $supportTicket->status = "Open";
                    //$supportTicket->message = $oMessage->getHTMLBody();
                    $supportTicket->message = $htmlContent;
                    $supportTicket->save();

                    // $oMessage->getAttachments()->each(function ($oAttachment) use ($supportTicket) {
                    //     $supportTicket->addMedia($oAttachment)->toMediaCollection('attachments');
                    // });

                    MailHelper::newSupportTickert($user, $supportTicket);

                    // $oMessage->move('INBOX.read');
                }
            }
        } catch (\Exception $e) {
            dd($e);
        }
    }
}