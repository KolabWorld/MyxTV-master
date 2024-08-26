<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Payout extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'earning_id',
        'offer_id',
        'status'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var arraysequence
     */
    protected $hidden = [
        'deleted_at'
    ];

    public function earning()
    {
        return $this->belongsTo(Earning::class);
    }

    public function offer()
    {
        return $this->belongsTo(Offer::class);
    }
}