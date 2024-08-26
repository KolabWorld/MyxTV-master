<?php
namespace App\Models;

use PDF;
use DB;
use App\User;
use App\Models\Address;
use App\Models\PaymentTransaction;
use App\Services\Mailers\Mailer;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var arraysequence
     */
    protected $hidden = ['deleted_at'];

    protected $fillable = [
        'user_id',
        'invoice_type',
        'voucher_code',
        'voucher_amount',
        'due_date',
        'auto_renewal',
        'currency',
        'created_by',
    ];

    protected $casts = [
        'customer' => 'array',
        'header' => 'array',
    ];

    public function invoiceable() {
        return $this->morphTo();
    }

    public static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $user = User::with('currency')->find($model->user_id);
            $billingAddress = Address::with(['city', 'state', 'country'])
                ->where('addressable_id', '=', $user->id)
                ->first();

            $model->customer_name = $user->name;
            $model->customer_email = $user->email;
            $model->customer_phone = $user->phone;

            $customer = array(
                "billing_address" => array(
                    "name" => isset($billingAddress->name)?$billingAddress->name:"",
                    "mobile" => isset($billingAddress->mobile)?$billingAddress->mobile:"",
                    "email" => isset($billingAddress->email)?$billingAddress->email:"",
                    "address" => ((isset($billingAddress->line_1))?$billingAddress->line_1:""),
                    "landmark" => ((isset($billingAddress->landmark))?$billingAddress->landmark:""),
                    "gst_number" => ((isset($billingAddress->gst_number))?$billingAddress->gst_number:""),
                    "postal_code" => ((isset($billingAddress->postal_code))?$billingAddress->postal_code:""),
                    "city" => ((isset($billingAddress->city->name))?$billingAddress->city->name:""),
                    "state" => ((isset($billingAddress->state->name))?$billingAddress->state->name:""),
                    "state_id" => ((isset($billingAddress->state->id))?$billingAddress->state->id:""),
                    "country" => ((isset($billingAddress->country->name))?$billingAddress->country->name:"")
                ),
                'company_name' => $user->company_name
            );

            $model->customer = $customer;

            if(!$model->currency) {
                if($user->currency) {
                    $model->currency = $user->currency->alias;
                }
                else {
                    $model->currency = 'INR';
                }
            }

        });

        self::updating(function ($model) {

            // $model->amount_pending = $model->total_amount - ($model->amount_recieved ?: 0);

            // if($model->amount_pending && $model->total_amount > $model->amount_pending ) {
            //     $model->payment_status = 'partial';
            // }
            // if($model->total_amount && $model->amount_pending == 0) {
            //     $model->payment_status = 'paid';
            // }

        });
    }

    public function calculateInvoice() {
        $itemModel = InvoiceItem::where('invoice_id', $this->id);

        $this->sub_total = $itemModel->sum('sub_total');
        $this->total_tax = $itemModel->sum('total_tax');
        $this->total_amount = $itemModel->sum('total_amount');

        $this->invoice_total = round(($this->total_amount - $this->voucher_amount), 2);
        $this->amount_pending = $this->invoice_total;

    }

    public function calculatePayments() {
        $this->amount_pending = $this->invoice_total - ($this->amount_recieved ?: 0);

        if($this->amount_pending > 0 && $this->amount_recieved > 0 && $this->invoice_total > $this->amount_pending ) {
            $this->payment_status = 'partial';
        }
        else if($this->invoice_total && $this->amount_pending <= 0) {
            $this->payment_status = 'paid';
            $this->status = 'completed';

        }
        else {
            $this->payment_status = 'unpaid';
        }

    }

    public function items(){
        return $this->hasMany(InvoiceItem::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function createdBy(){
        return $this->belongsTo(User::class);
    }

    public function updatedBy(){
        return $this->belongsTo(User::class);
    }

    public function currency(){
        return $this->belongsTo(Currency::class);
    }

    public function comments() {
        return $this->morphMany(Comment::class, 'commentable');
    }

    public function comment() {
        return $this->morphOne(Comment::class, 'commentable');
    }

    public function sendInvoiceConfirmationMail($emailTemplate = "Invoice Created") {
       //echo $emailTemplate;exit;
        $welcomeEmail = ServerWelcomeEmail::where('name', '=', $emailTemplate)
            ->first();
        $itemContents = '';
        $siteLink = env('APP_URL', '');
        $invoiceData = $this->load('items');
        $invoiceItems = InvoiceItem::where('invoice_id', $this->id)->get();
        $itemCounter = 0;$old_item_sequence=0; 
        foreach($invoiceItems as $key => $value) {
          if($itemCounter!=0 && $value->item_sequence!=$old_item_sequence){
            $itemContents .= '<p style="width:100%;height:10px;background-color:#f5f5f5;">&nbsp;</p>';
          }
          if($value->item_sequence==$old_item_sequence){
            $itemContents .= "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;- ".$value->item .'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Qty:'.$value->quantity.'<br/>';
          } else {
              $itemContents .= $value->item .'<br/>';
          }
          $itemCounter++;
          $old_item_sequence = $value->item_sequence;
        }
        if($welcomeEmail){
            $description = $welcomeEmail->description;
            $emailKeywords = array(
                "{CUSTOMER_ID}" => $this->user_id,
                "{CLIENT_NAME}" => $this->customer_name,
                "{INVOICE_DATE}" => $this->created_at,
                "{INVOICE_NUMBER}" => $this->invoice_number,
                "{PAYMENT_STATUS}" => $this->payment_status,
                "{INVOICE_TOTAL}" => $this->currency." ".$this->invoice_total,
                "{AMOUNT_RECIEVED}" => $this->currency." ".$this->amount_recieved,
                "{AMOUNT_PENDING}" => $this->currency." ".$this->amount_pending,
                "{INVOICE_DUE_DATE}" => $this->due_date,
                "{INVOICE_HTML_CONTENTS}" => $itemContents,
                "{INVOICE_LINK}" => $siteLink,
                "{SIGNATURE}" => "",
            );
            foreach($emailKeywords as $key => $val){
                $description = str_replace("$key",$val, $description);
            }

            $servicemode =  ""; 
            $serviceid =  "";
            if($invoiceData['invoice_type'] == 'renew_service') {
                $service = UserService::find($invoiceData->invoiceable_id);
                if($service) {
                   $servicemode =  $service->mode; 
                   $serviceid =  $service->dedicated_ip;
                }
            }

           $pdf = PDF::loadView('pdf.invoice',
          //  die( view('pdf.invoice',
                array(
                    'invoice' => $invoiceData,
                    'servicemode' => $servicemode,
                    'serviceid' => $serviceid,
                    'stamp' => public_path('/assets/img/aims-stamp.png'),
                    // 'logo' => public_path('/frontend/images/logo.png'),
                    'logo' => '/frontend/images/logo.png',
                    'line' => public_path('/assets/img/Line.png')
                )
            );

            $fileName = "Invoice_".str_random(5);

            
            $attachment = storage_path('app/public/invoice/'.$fileName.'.pdf');
            $invoicePdf = $pdf->save($attachment);

            $mailbox = new MailBox;

            $mailArray = array(
                "name" => $this->customer_name,
                "mobile" => $this->customer_phone,
                "email" => $this->customer_email,
                "email_template_name" => $welcomeEmail->name,
                "from_name" => $welcomeEmail->fromname,
                "from_email" => $welcomeEmail->fromemail,
                "subject" => $welcomeEmail->subject,
                "copy_to" => $welcomeEmail->copyto,
                "description" => $description
            );
            $user = User::where('id', '=', $this->user_id)
            ->first();

            $mailbox->mail_body = json_encode($mailArray);
            $mailbox->subject = $welcomeEmail->subject;
            $mailbox->mail_to = $this->customer_email ?: 'test@miditech.co.in';
            if($welcomeEmail->copyto){
                $mailbox->mail_cc = $welcomeEmail->copyto;
            }
            if(isset($user->alternate_emailids) && $user->alternate_emailids!=""){
                $mailbox->mail_cc = $mailbox->mail_cc.",".$user->alternate_emailids;
            }
           
            $mailbox->category = $welcomeEmail->name;
            $mailbox->attachment = $attachment;
            $mailbox->layout = "email.email-template";
            $mailbox->save();

            $mailer = new Mailer;
            $mailer->emailTo($mailbox);
        }
    }


    public function sendInvoiceDueMail($subject) {

        $welcomeEmail = ServerWelcomeEmail::where('name', '=', 'Invoice Created')
            ->first();

        $itemContents = '';
        $siteLink = env('APP_URL', '');
        $invoiceData = $this->load('items');
        $invoiceItems = InvoiceItem::where('invoice_id', $this->id)->get();
        $itemCounter = 0;$old_item_sequence=0;
        foreach($invoiceItems as $key => $value) {
          if($itemCounter!=0 && $value->item_sequence!=$old_item_sequence){
            $itemContents .= '<p style="width:100%;height:10px;background-color:#f5f5f5;">&nbsp;</p>';
          }
          if($value->item_sequence==$old_item_sequence){
            $itemContents .= "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;- ".$value->item .'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Qty:'.$value->quantity.'<br/>';
          } else {
              $itemContents .= $value->item .'<br/>';
          }
          $itemCounter++;
          $old_item_sequence = $value->item_sequence;
        }
        if($welcomeEmail){
            $description = $welcomeEmail->description;
            $emailKeywords = array(
                "{CUSTOMER_ID}" => $this->user_id,
                "{CLIENT_NAME}" => $this->customer_name,
                "{INVOICE_DATE}" => $this->created_at,
                "{INVOICE_NUMBER}" => $this->invoice_number,
                "{PAYMENT_STATUS}" => $this->payment_status,
                "{INVOICE_TOTAL}" => $this->currency." ".$this->invoice_total,
                "{AMOUNT_RECIEVED}" => $this->currency." ".$this->amount_recieved,
                "{AMOUNT_PENDING}" => $this->currency." ".$this->amount_pending,
                "{INVOICE_DUE_DATE}" => $this->due_date,
                "{INVOICE_HTML_CONTENTS}" => $itemContents,
                "{INVOICE_LINK}" => $siteLink,
                "{SIGNATURE}" => "",
            );
            foreach($emailKeywords as $key => $val){
                $description = str_replace("$key",$val, $description);
            }
            $servicemode =  ""; 
            $serviceid =  "";
            if($invoiceData['invoice_type'] == 'renew_service') {
                $service = UserService::find($invoiceData->invoiceable_id);
                if($service) {
                   $servicemode =  $service->mode; 
                   $serviceid =  $service->dedicated_ip;
                }
            }
           $pdf = PDF::loadView('pdf.invoice',
          //  die( view('pdf.invoice',
                array(
                    'invoice' => $invoiceData,
                    'servicemode' => $servicemode,
                    'serviceid' => $serviceid,
                    'stamp' => public_path('/assets/img/aims-stamp.png'),
                    // 'logo' => public_path('/frontend/images/logo.png'),
                    'logo' => '/frontend/images/logo.png',
                    'line' => public_path('/assets/img/Line.png')
                )
            );

            $fileName = "Invoice_".str_random(5);

            $attachment = storage_path('app/public/invoice/'.$fileName.'.pdf');
            $invoicePdf = $pdf->save($attachment);

         

            $mailbox = new MailBox;

            $mailArray = array(
                "name" => $this->customer_name,
                "mobile" => $this->customer_phone,
                "email" => $this->customer_email,
                "email_template_name" => $welcomeEmail->name,
                "from_name" => $welcomeEmail->fromname,
                "from_email" => $welcomeEmail->fromemail,
                "subject" => $welcomeEmail->subject,
                "copy_to" => $welcomeEmail->copyto,
                "description" => $description
            );

            $mailbox->mail_body = json_encode($mailArray);
            $mailbox->subject = $subject;
            $mailbox->mail_to = $this->customer_email ?: 'test@miditech.co.in';
            if($welcomeEmail->copyto){
                $mailbox->mail_cc = $welcomeEmail->copyto;
            }
            $mailbox->category = $welcomeEmail->name;
            $mailbox->attachment = $attachment;
            $mailbox->layout = "email.email-template";
            $mailbox->save();

            $mailer = new Mailer;
            $mailer->emailTo($mailbox);
        }
    }

    public function sendInvoiceOverDueMail() {

        $welcomeEmail = ServerWelcomeEmail::where('name', '=', 'Invoice Overdue Notice')
            ->first();

        $itemContents = '';
        $siteLink = env('APP_URL', '');
        $invoiceData = $this->load('items');
        $invoiceItems = InvoiceItem::where('invoice_id', $this->id)->get();
        $itemCounter = 0;$old_item_sequence=0;
        foreach($invoiceItems as $key => $value) {
          if($itemCounter!=0 && $value->item_sequence!=$old_item_sequence){
            $itemContents .= '<p style="width:100%;height:10px;background-color:#f5f5f5;">&nbsp;</p>';
          }
          if($value->item_sequence==$old_item_sequence){
            $itemContents .= "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;- ".$value->item .'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Qty:'.$value->quantity.'<br/>';
          } else {
              $itemContents .= $value->item .'<br/>';
          }
          $itemCounter++;
          $old_item_sequence = $value->item_sequence;
        }
        if($welcomeEmail){
            $description = $welcomeEmail->description;
            $emailKeywords = array(
                "{CLIENT_NAME}" => $this->customer_name,
                "{INVOICE_DATE}" => $this->created_at,
                "{INVOICE_NUMBER}" => $this->invoice_number,
                "{PAYMENT_STATUS}" => $this->payment_status,
                "{INVOICE_TOTAL}" => $this->currency." ".$this->invoice_total,
                "{AMOUNT_RECIEVED}" => $this->currency." ".$this->amount_recieved,
                "{INVOICE_BALANCE}" => $this->currency." ".$this->amount_pending,
                "{INVOICE_DUE_DATE}" => $this->due_date,
                "{INVOICE_HTML_CONTENTS}" => $itemContents,
                "{INVOICE_LINK}" => $siteLink,
                "{INVOICE_PAYMENT_METHOD}" => 'Online',
                "{SIGNATURE}" => "",
            );
            
            foreach($emailKeywords as $key => $val){
                $description = str_replace("$key",$val, $description);
            }
            $servicemode =  ""; 
            $serviceid =  "";
            if($invoiceData['invoice_type'] == 'renew_service') {
                $service = UserService::find($invoiceData->invoiceable_id);
                if($service) {
                   $servicemode =  $service->mode; 
                   $serviceid =  $service->dedicated_ip;
                }
            }
           $pdf = PDF::loadView('pdf.invoice',
          //  die( view('pdf.invoice',
                array(
                    'invoice' => $invoiceData,
                    'servicemode' => $servicemode,
                    'serviceid' => $serviceid,
                    'stamp' => "",
                    // 'logo' => public_path('/frontend/images/logo.png'),
                    'logo' => '/frontend/images/logo.png',
                    'line' => public_path('/assets/img/Line.png')
                )
            );

            $fileName = "Invoice_".str_random(5);

            $attachment = storage_path('app/public/invoice/'.$fileName.'.pdf');
            $invoicePdf = $pdf->save($attachment);


          //  $invoicePdf = $pdf->save(storage_path('app/public/invoice/'.$fileName.'.pdf'));
            //$attachment = env('APP_URL','').'/storage/invoice/'.$fileName.'.pdf';

            $mailbox = new MailBox;

            $mailArray = array(
                "name" => $this->customer_name,
                "mobile" => $this->customer_phone,
                "email" => $this->customer_email,
                "email_template_name" => $welcomeEmail->name,
                "from_name" => $welcomeEmail->fromname,
                "from_email" => $welcomeEmail->fromemail,
                "subject" => $welcomeEmail->subject,
                "copy_to" => $welcomeEmail->copyto,
                "description" => $description
            );

            $mailbox->mail_body = json_encode($mailArray);
            $mailbox->subject =  $welcomeEmail->subject;
            $mailbox->mail_to = $this->customer_email ?: 'test@miditech.co.in';
            if($welcomeEmail->copyto){
                $mailbox->mail_cc = $welcomeEmail->copyto;
            }
            $mailbox->category = $welcomeEmail->name;
            $mailbox->attachment = $attachment;
            $mailbox->layout = "email.email-template";
            $mailbox->save();

            $mailer = new Mailer;
            $mailer->emailTo($mailbox);
        }
    }

    public function paymentTransactions() {
        return $this->morphMany(PaymentTransaction::class, 'payable')->with('paymentChannel');
    }

    public function sendDomainInvoiceConfirmationMail() {

        $welcomeEmail = ServerWelcomeEmail::where('name', '=', 'Domain Renewal Invoice Created')
            ->first();

        $itemContents = '';
        $siteLink = env('APP_URL', '');
        $invoiceData = $this->load('items');
        $invoiceItems = InvoiceItem::where('invoice_id', $this->id)->get();
        $itemCounter = 0;$old_item_sequence=0; 
        foreach($invoiceItems as $key => $value) {
          if($itemCounter!=0 && $value->item_sequence!=$old_item_sequence){
            $itemContents .= '<p style="width:100%;height:10px;background-color:#f5f5f5;">&nbsp;</p>';
          }
          if($value->item_sequence==$old_item_sequence){
            $itemContents .= "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;- ".$value->item .'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Qty:'.$value->quantity.'<br/>';
          } else {
              $itemContents .= $value->item .'<br/>';
          }
          $itemCounter++;
          $old_item_sequence = $value->item_sequence;
        }
        if($welcomeEmail){
            $description = $welcomeEmail->description;
            $emailKeywords = array(
                "{CUSTOMER_ID}" => $this->user_id,
                "{CLIENT_NAME}" => $this->customer_name,
                "{INVOICE_DATE}" => $this->created_at,
                "{INVOICE_NUMBER}" => $this->invoice_number,
                "{PAYMENT_STATUS}" => $this->payment_status,
                "{INVOICE_TOTAL}" => $this->currency." ".$this->invoice_total,
                "{AMOUNT_RECIEVED}" => $this->currency." ".$this->amount_recieved,
                "{AMOUNT_PENDING}" => $this->currency." ".$this->amount_pending,
                "{INVOICE_DUE_DATE}" => $this->due_date,
                "{INVOICE_HTML_CONTENTS}" => $itemContents,
                "{INVOICE_LINK}" => $siteLink,
                "{SIGNATURE}" => "",
            );
            foreach($emailKeywords as $key => $val){
                $description = str_replace("$key",$val, $description);
            }

            $servicemode =  ""; 
            $serviceid =  "";
            if($invoiceData['invoice_type'] == 'renew_service') {
                $service = UserService::find($invoiceData->invoiceable_id);
                if($service) {
                   $servicemode =  $service->mode; 
                   $serviceid =  $service->dedicated_ip;
                }
            }

           $pdf = PDF::loadView('pdf.invoice',
          //  die( view('pdf.invoice',
                array(
                    'invoice' => $invoiceData,
                    'servicemode' => $servicemode,
                    'serviceid' => $serviceid,
                    'stamp' => public_path('/assets/img/aims-stamp.png'),
                    // 'logo' => public_path('/frontend/images/logo.png'),
                    'logo' => '/frontend/images/logo.png',
                    'line' => public_path('/assets/img/Line.png')
                )
            );

            $fileName = "Invoice_".str_random(5);

            
            $attachment = storage_path('app/public/invoice/'.$fileName.'.pdf');
            $invoicePdf = $pdf->save($attachment);

            $mailbox = new MailBox;

            $mailArray = array(
                "name" => $this->customer_name,
                "mobile" => $this->customer_phone,
                "email" => $this->customer_email,
                "email_template_name" => $welcomeEmail->name,
                "from_name" => $welcomeEmail->fromname,
                "from_email" => $welcomeEmail->fromemail,
                "subject" => $welcomeEmail->subject,
                "copy_to" => $welcomeEmail->copyto,
                "description" => $description
            );

            $mailbox->mail_body = json_encode($mailArray);
            $mailbox->subject = $welcomeEmail->subject;
            $mailbox->mail_to = $this->customer_email ?: 'test@miditech.co.in';
            if($welcomeEmail->copyto){
                $mailbox->mail_cc = $welcomeEmail->copyto;
            }
            $mailbox->category = $welcomeEmail->name;
            $mailbox->attachment = $attachment;
            $mailbox->layout = "email.email-template";
            $mailbox->save();

            $mailer = new Mailer;
            $mailer->emailTo($mailbox);
        }
    }
}
