<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CountryOffer extends Model
{

    protected $table = 'country_offer';

    protected $fillable = [
        'offer_id', 
        'country_id', 
        'created_at', 
        'updated_at'
    ];

    public function offer()
    {
        return $this->belongsTo(Offer::class);
    }

    public function country()
    {
        return $this->belongsTo(Country::class);
    }

}
