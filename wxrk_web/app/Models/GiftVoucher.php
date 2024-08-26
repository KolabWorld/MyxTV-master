<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GiftVoucher extends Model
{
    //
    protected $table = 'gift_vouchers';

    protected $fillable = [
        'voucher_code',
        'sender_id',
        'user_id',
        'sender_detail',
        'email_id',
        'currency_id',
        'voucher_amount',
        'used_amount',
        'available_amount',
        'expiry_date',
        'status',
    ];


    protected $casts = [
        'sender_detail' => 'array',
    ];   


}
