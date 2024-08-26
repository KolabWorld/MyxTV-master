<?php
namespace App\Models;

use App\User;
use App\Models\PaymentChannel;
use Illuminate\Database\Eloquent\Model;

class PaymentTransaction extends Model
{
    protected $table = 'payment_transactions';

    protected $fillable = [
        'user_id', 
        'admin_id', 
        'payment_channel_id', 
        'offer_id', 
        'payable_type', 
        'payable_id', 
        'transection_id', 
        'payee_name', 
        'payee_email', 
        'payee_mobile', 
        'currency',
        'amount', 
        'currency_code', 
        'channel_invoice_id', 
        'channel_order_id', 
        'payment_link', 
        'status', 
        'message', 
        'response', 
        'created_at', 
        'updated_at'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var arraysequence
     */
    protected $hidden = [
        'deleted_at'
    ];

    protected $cast = [
        'response' => 'array'
    ];

    public function payable() {
        return $this->morphTo();
    }

    public function user() {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function paymentChannel() {
        return $this->belongsTo(PaymentChannel::class, 'payment_channel_id')->withTrashed();
    }

    public function subscriptionPlanLog() {
        return $this->belongsTo(SubscriptionPlanLog::class, 'subscription_plan_log_id');
    }

    public function offer() {
        return $this->belongsTo(Offer::class);
    }

    public function admin() {
        return $this->belongsTo(Admin::class);
    }
}
