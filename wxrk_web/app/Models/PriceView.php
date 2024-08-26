<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PriceView extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'from_date', 
        'to_date', 
        'offer_price_per_day', 
        'premium_price_per_day',
        'status', 
        'created_by', 
        'updated_by'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'deleted_at'
    ];

    public function offers()
    {
        return $this->hasMany(Offer::class,);
    }

}