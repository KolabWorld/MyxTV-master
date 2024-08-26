<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdminOffer extends Model
{

    protected $table = 'admin_offer';

    protected $fillable = [
        'admin_id', 
        'offer_id', 
        'created_at', 
        'updated_at'
    ];

    public function admin()
    {
        return $this->belongsTo(Admin::class);
    }

    public function offer()
    {
        return $this->belongsTo(Offer::class);
    }

}
