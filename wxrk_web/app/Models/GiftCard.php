<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;

class GiftCard extends Model implements HasMedia
{

    use  HasMediaTrait;
    protected $fillable = [
        'title',
        'short_description',
        'status',
        'custom_value',
        'validity',
        'created_at', 
        'updated_at'
    ];
     
    //protected $hidden = ['deleted_at'];
    protected $appends = [
        'featured_image',
        'min_price',
        'max_price',
    ];

    public function giftCardItem()
    {
        return $this->hasMany(GiftCardItem::class);
    }
    public function getFeaturedImageAttribute()
    {

        if ($this->getMedia('featured_image')->isEmpty()) {
            return false;
        } else {
            return $this->getMedia('featured_image')->last()->getFullUrl();
        }
    }

    public function getMinPriceAttribute()
    {

        return GiftCardItem::min('price');
        
    }

    public function getMaxPriceAttribute()
    {

        return GiftCardItem::max('price');
        
    }
}
