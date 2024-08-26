<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BankAccount extends Model
{

    protected $table = 'bank_accounts';

    protected $fillable = [
        'bank_accountable_id', 
        'bank_accountable_type', 
        'bank_name', 
        'account_number', 
        'account_holder_name', 
        'iban_code', 
        'swift_code'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var arraysequence
     */
    protected $hidden = [
        'deleted_at'
    ];

    public function bankAccountable(){
        return $this->morphTo();
    }
}