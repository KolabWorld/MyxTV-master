<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CountryEvent extends Model
{

    protected $table = 'country_event';

    protected $fillable = [
        'event_id', 
        'country_id', 
        'created_at', 
        'updated_at'
    ];

    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    public function country()
    {
        return $this->belongsTo(Country::class);
    }

}
