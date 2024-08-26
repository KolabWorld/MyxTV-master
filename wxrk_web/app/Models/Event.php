<?php
namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;

class Event extends Model implements HasMedia
{
    use SoftDeletes, HasMediaTrait;

    protected $fillable = [
        'event_type_id', 
        'name', 
        'event_host',
        'description', 
        'highlights', 
        'organizer', 
        'how_to_join', 
        'country_id', 
        'start_date_time',
        'end_date_time', 
        'venue', 
        'company_name', 
        'about_the_company', 
        'attachment_type', 
        'is_auto_play', 
        'status', 
        'created_by', 
        'updated_by'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var arraysequence
     */

    protected $appends = [
        'total_members', 
        'remaining_time', 
        'thumbnail_image',
        'company_logo',
        'banner', 
        'sponser', 
        'already_joined', 
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

    public function eventType()
    {
        return $this->belongsTo(EventType::class);
    }

    public function countries()
    {
        return $this->belongsToMany(Country::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class)->withTimestamps();
    }
    
    public function userMapping()
    {
        return $this->hasMany(EventUser::class)->with(['event','user']);
    }

    public function createdBy()
    {
        return $this->belongsTo(Admin::class);
    }

    public function updatedBy()
    {
        return $this->belongsTo(Admin::class);
    }

    public function getThumbnailImageAttribute()
    {
        
        if($this->getMedia('thumbnail_image')->isEmpty()) {
            return '';
        }else {
            return $this->getMedia('thumbnail_image')->first()->getFullUrl();
        }
    }

    public function getCompanyLogoAttribute()
    {

        if ($this->getMedia('company_logo')->isEmpty()) {
            return '';
        } else {
            return $this->getMedia('company_logo')->first()->getFullUrl();
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

    public function getSponsers()
    {
        if ($this->getMedia('sponsers')->isEmpty()) {
            return [];
        } else {
            $media =  $this->getMedia('sponsers')->all();
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

    public function getSponserAttribute()
    {
        if ($this->getMedia('sponsers')->isEmpty()) {
            return [];
        } else {
            $media =  $this->getMedia('sponsers')->all();
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
        $this->addMediaCollection('thumbnail_image')
            ->singleFile();

        $this->addMediaCollection('company_logo')
            ->singleFile();
    }

    public function getTotalMembersAttribute(){
        $totalJoiner = count($this->users);
        return $totalJoiner;
    }

    public function getRemainingTimeAttribute(){
        $currentDate = date('Y-m-d H:i:s');
        $startDate = $this->start_date_time;
        $diff = strtotime($startDate) - strtotime($currentDate);
        $temp = $diff/86400; // (60 sec/min * 60 min/hr * 24 hr/day = 86400 sec/day)
        $dd = floor($temp); $temp = 24*($temp-$dd); //Days
        $hh = floor($temp); $temp = 60*($temp-$hh); //Hours
        $mm = floor($temp); $temp = 60*($temp-$mm); //Minutes
        $ss = floor($temp); //Seconds
        $remaining_time = $dd. 'd:'.$hh. 'h:'.$mm. 'm:'.$ss. 's';
        
        if($dd < 0 || $hh < 0 || $mm < 0 || $ss < 0){
            $remaining_time =  '0d: 0h: 0m: 0s';
        }
        return $remaining_time;
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