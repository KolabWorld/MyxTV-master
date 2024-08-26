<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;

class AdminProfile extends Model implements HasMedia
{

    use HasMediaTrait;

    protected $fillable = [
        'admin_id',
        'who_we_are',
        'purpose',
        'status',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var arraysequence
     */
    protected $hidden = [
        'deleted_at',
        'image'
    ];

    public function admin()
    {
        return $this->belongsTo(Admin::class);
    }

    public function registerMediaCollections()
    {
        $this->addMediaCollection('image')
            ->singleFile();
    }
    
    public function getImageAttribute()
    {

        if ($this->getMedia('image')->isEmpty()) {
            return false;
        } else {
            return $this->getMedia('image')->first()->getFullUrl();
        }
    }

}