<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;

class SocialMedia extends Model implements HasMedia
{

    use SoftDeletes, HasMediaTrait;

    protected $table = 'social_media';

    protected $fillable = [
        'name', 
        'link', 
        'icon', 
        'description', 
        'created_by', 
        'updated_by', 
        'created_at', 
        'updated_at'
    ];

    protected $appends = ['image'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var arraysequence
     */
    protected $hidden = ['media','deleted_at'];

    public function createdBy(){
        return $this->belongsTo(User::class);
    }

    public function updatedBy(){
        return $this->belongsTo(User::class);
    }

    public function registerMediaCollections()
    {
        $this->addMediaCollection('image')
            ->singleFile();
    }

    public function getImageAttribute(){

        if($this->getMedia('image')->isEmpty()) {
            return false;
        }
        else {
            return $this->getMedia('image')->first()->getFullUrl();
        }
    }

}
