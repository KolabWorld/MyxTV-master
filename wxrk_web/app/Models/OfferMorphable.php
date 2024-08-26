<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OfferMorphable extends Model
{

    protected $table = 'offer_morphables';

    protected $fillable = [
        'offer_id',
        'offerable_id',
        'offerable_type'
    ];


    public function offerable()
    {
        return $this->morphTo();
    }
}