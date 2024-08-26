<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class  CurrencyRate extends Model
{
    protected $table = 'currency_rates';

    protected $fillable = [
        'name', 
        'rate', 
        'currency_id', 
        'country_id'
    ];

    public function currency()
    {
        return $this->belongsTo(Currency::class);
    }

    public function country()
    {
        return $this->belongsTo(Country::class);
    }

}
