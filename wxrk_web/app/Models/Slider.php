<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Illuminate\Database\Eloquent\SoftDeletes;

class Slider extends Model implements HasMedia
{

    use SoftDeletes, HasMediaTrait;

    protected $fillable = [
        'type', 
        'title', 
        'button_text', 
        'button_url', 
        'attachment_type', 
        'is_auto_play', 
        'description',
        'status',
    ];
    
    protected $appends = ['attachment'];
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var arraysequence
     */
    protected $hidden = [
        'deleted_at',
        'media'
    ];

    public function registerMediaCollections()
    {
        $this->addMediaCollection('attachment')
            ->singleFile();
    }

    public function getAttachmentAttribute(){

        if($this->getMedia('attachment')->isEmpty()) {
            return false;
        }
        else {
            return $this->getMedia('attachment')->first()->getFullUrl();
        }
    }

}
