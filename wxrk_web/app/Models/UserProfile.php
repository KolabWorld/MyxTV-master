<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserProfile extends Model
{

    use SoftDeletes;

    protected $table = 'user_profiles';

    protected $fillable = [
        'user_id',
        'client_group_id', 
        'language_id', 
        'payment_channel_id', 
        'billing_contact_id', 
        'currency_id', 
        'security_question_id', 
        'security_answer', 
        'status', 
        'is_late_fee', 
        'is_overdue_notice', 
        'is_tax_exempt', 
        'is_seperate_invoice', 
        'is_cc_processing', 
        'is_marketing_email', 
        'is_automatic_status_update', 
        'is_single_sign_on', 
        'is_two_factor_authentication', 
        'register_as_a_partner', 
        'admin_note', 
        'created_by', 
        'updated_by', 
        'created_at', 
        'updated_at'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var arraysequence
     */
    protected $hidden = ['deleted_at'];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function clientGroup(){
        return $this->belongsTo(ClientGroup::class);
    }

    public function language(){
        return $this->belongsTo(Language::class);
    }

    public function paymentChannel(){
        return $this->belongsTo(PaymentChannel::class);
    }

    public function currency(){
        return $this->belongsTo(Currency::class);
    }

    public function securityQuestion(){
        return $this->belongsTo(SecurityQuestion::class);
    }

    public function createdBy(){
        return $this->belongsTo(User::class);
    }

    public function updatedBy(){
        return $this->belongsTo(User::class);
    }

}
