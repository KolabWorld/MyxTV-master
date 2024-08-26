<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;

class Offer extends Model implements HasMedia
{
    use SoftDeletes, HasMediaTrait;

    protected $fillable = [
        'price_view_id',
        'country_id',
        'offer_type_id',
        'offer_category_id',
        'premium_category_id',
        'offer_name',
        'offer_price',
        'offer_period',
        'offer_listing_price',
        'offer_listing_value',
        'premium_listing_period',
        'premium_listing_price',
        'premium_listing_value',
        'total_value',
        'start_date',
        'offer_end_date',
        'premium_offer_end_date',
        'premium_valid_date',
        'attachment_type',
        'is_auto_play',
        'stock',
        'low_stock',
        'you_get',
        'time_to_redeem',
        'quantity_per_user',
        'shipping_cost',
        'highlight_of_offer',
        'details_of_offer',
        'company_name',
        'about_the_company',
        'link',
        'offer_code_bg_color',
        'offer_code_text_color',
        'status',
        'created_by',
        'updated_by'
    ];

    protected $casts = [
        'stock' => 'string',
        'low_stock' => 'string',
        'is_low_stock' => 'string',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var arraysequence
     */

    protected $appends = [
        'remaining_days',
        'company_logo',
        'thumbnail_image',
        'banner',
        'sold_value',
        'already_joined', 
        'remaining_promocodes'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'remember_token',
        'deleted_at',
        'media'
    ];

    public function priceView()
    {
        return $this->belongsTo(PriceView::class);
    }

    public function offerType()
    {
        return $this->belongsTo(OfferType::class);
    }

    public function offerCategory()
    {
        return $this->belongsTo(OfferCategory::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    public function premiumCategory()
    {
        return $this->belongsTo(PremiumCategory::class);
    }

    public function promoCodes()
    {
        return $this->hasMany(PromoCode::class, 'offer_id');
    }

    public function soldPromoCodes()
    {
        return $this->hasMany(PromoCode::class, 'offer_id')
            ->where('status', 'sold');
    }

    public function getRemainingPromocodesAttribute()
    {
        return count($this->promoCodes) - count($this->soldPromoCodes);
    }

    public function orders()
    {
        return $this->hasMany(Order::class, 'offer_id');
    }

    public function countries()
    {
        return $this->belongsToMany(Country::class);
    }

    public function createdBy()
    {
        return $this->belongsTo(Admin::class, 'created_by');
    }

    public function updatedBy()
    {
        return $this->belongsTo(Admin::class);
    }

    public function getCompanyLogoAttribute()
    {
        if ($this->getMedia('company_logo')->isEmpty()) {
            return '';
        } else {
            return $this->getMedia('company_logo')->first()->getFullUrl();
        }
    }

    public function getThumbnailImageAttribute()
    {
        if ($this->getMedia('thumbnail_image')->isEmpty()) {
            return '';
        } else {
            return $this->getMedia('thumbnail_image')->first()->getFullUrl();
        }
    }

    public function getBanners()
    {
        if ($this->getMedia('banners')->isEmpty()) {
            return [];
        } else {
            $media =  $this->getMedia('banners')->all();
            $images = [];
            foreach ($media as $image) {
                $image->full_url = $image->getFullUrl();
                $images[] = $image;
            }
            return $images;
        }
    }

    public function getBannerAttribute()
    {
        if ($this->getMedia('banners')->isEmpty()) {
            return [];
        } else {
            $media =  $this->getMedia('banners')->all();
            $images = [];
            foreach ($media as $image) {
                $image->full_url = $image->getFullUrl();
                $images[] = $image;
            }
            return $images;
        }
    }

    public function registerMediaCollections()
    {
        $this->addMediaCollection('company_logo')
            ->singleFile();

        $this->addMediaCollection('thumbnail_image')
            ->singleFile();
    }

    public function getRemainingDaysAttribute()
    {

        $end_date = date('Y-m-d', (strtotime($this->start_date . ' +' . $this->offer_period . ' days')));
        $future = strtotime($end_date);
        $now = time();
        $timeleft = $future - $now;
        $remaining_days = intval(round((($timeleft / 24) / 60) / 60));

        return ($remaining_days > 0 ? $remaining_days : 0) . ' days';
    }

    public function getSoldValueAttribute()
    {
        $soldCoupons = PromoCode::where('offer_id', $this->id)
            ->where('status', 'sold')
            ->count();

        return $soldCoupons * $this->offer_price;
    }

    public function getAlreadyJoinedAttribute(){
        $user = \Auth::user();
        $ids = $this->users()->pluck('users.id')->toArray();
        if($user && in_array($user->id, $ids))
            return 1;
        else
            return 0;
    }
}
