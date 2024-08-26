<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class OtpRequest extends Model
{

    protected $table = "otp_request";

    protected $fillable = [
        'otp',
        'mobile',
        'device_address',
        'user_id',
        'expired_at'
    ];
}
