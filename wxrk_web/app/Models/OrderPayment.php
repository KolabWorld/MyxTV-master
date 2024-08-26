<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrderPayment extends Model
{
    protected $fillable = [
        'payment_channel_id',
        'order_id',
        'payee_name',
        'payee_email',
        'payee_mobile',
        'amount'
    ];

    public function order(){
        return $this->belongsTo(Order::class);
    }

    public function paymentChannel(){
        return $this->belongsTo(PaymentChannel::class);
    }
}
