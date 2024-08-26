<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{

    protected $table = 'addresses';

    protected $fillable = [
        'addressable_id',
        'addressable_type',
        'geo_address',
        'geo_latitude',
        'geo_longitude',
        'name',
        'mobile',
        'email',
        'line_1',
        'line_2',
        'line_3',
        'district',
        'landmark',
        'city_id',
        'state_id',
        'country_id',
        'postal_code',
        'gst_number',
        'type'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var arraysequence
     */
    protected $hidden = [
        'deleted_at'
    ];

    public function addressable()
    {
        return $this->morphTo();
    }

    public function city()
    {
        return $this->belongsTo(City::class);
    }

    public function state()
    {
        return $this->belongsTo(State::class);
    }

    public function country()
    {
        return $this->belongsTo(Country::class);
    }
}