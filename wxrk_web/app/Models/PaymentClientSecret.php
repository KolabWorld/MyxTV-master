<?php
namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PaymentClientSecret extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name', 
        'payment_channel_id', 
        'user_type', 
        'user_id', 
        'reseller_id', 
        'client_id', 
        'client_secret'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var arraysequence
     */

    protected $hidden = ['deleted_at'];

    public function paymentChannel(){
        return $this->belongsTo(PaymentChannel::class);
    }

    public function reseller(){
        return $this->belongsTo(Client::class, 'reseller_id');
    }

}
