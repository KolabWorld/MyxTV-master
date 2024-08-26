<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MailBox extends Model
{
    use SoftDeletes;
    const STATUS_PENDING = 'pending';
    const STATUS_COMPLETED = 'success';
    const STATUS_FAILED = 'failed';

    protected $table = 'mail_box';

    protected $fillable = [
        'mail_to',
        'mail_cc',
        'mail_bcc',
        'subject',
        'mail_body',
        'attachment',
        'status',
        'response',
        'category',
        'layout'
    ];
    
    protected $casts = [
    	"mail_body" => 'array'
    ];

    //public function setMailCcAttribute($mailCc) {
      //  $this->attributes['mail_cc'] = $mailCc.','.'support@miditech.co.in';
    //}
}
