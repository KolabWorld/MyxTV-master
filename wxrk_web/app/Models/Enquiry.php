<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Enquiry extends Model
{

    protected $fillable = [
        'name',
        'store_name',
        'email',
        'mobile',
        'description',
        'enquiry_type',
        'geo_address',
        'geo_latitude',
        'geo_longitude',
        'ip_address'
    ];

}
