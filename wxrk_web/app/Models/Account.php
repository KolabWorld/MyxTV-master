<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Account extends Model
{

    protected $table = 'accounts';

    protected $fillable = [
        'accountable_id',
        'accountable_type',
        'bank_name',
        'account_number',
        'account_holder_name',
        'bank_address',
        'iban_code',
        'swift_code',
        'other_detail_1',
        'other_detail_2',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var arraysequence
     */
    protected $hidden = [
        'deleted_at'
    ];

    public function accountable()
    {
        return $this->morphTo();
    }
}