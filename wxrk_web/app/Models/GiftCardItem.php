<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GiftCardItem extends Model
{
    protected $fillable = [
        'gift_card_id',
        'price',
    ];    
}
