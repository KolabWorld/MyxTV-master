<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Transactions extends Model
{
    protected $table = 'transactions';

    protected $fillable = [
        'user_id', 
        'payable_type', 
        'payable_id', 
        'transection_id',  //payment_id
        'payee_email',  //customer_email
        'currency',
        'amount',  //amount_total
        'status',  //payment_status
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
        return $this->belongsTo(Users::class, 'user_id');
    }


    public function updatePayble() {

        $this->payable->addPayout();
    }
}
