<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;

class Portfolio extends Model implements HasMedia
{

    use HasMediaTrait, SoftDeletes;

    protected $table = 'portfolios';

    protected $fillable = [
        'title',
        'designer_id',
        'status',
        'attachment_type',
        'is_featured',
        'created_at',
        'updated_at'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var arraysequence
     */
    protected $appends = ['attachment'];

    public function designer()
    {
        return $this->belongsTo(Designer::class);
    }

    public function registerMediaCollections()
    {
        $this->addMediaCollection('portfolios')
            ->singleFile();
    }

    public function getAttachmentAttribute()
    {

        if ($this->getMedia('portfolios')->isEmpty()) {
            return false;
        } else {
            return $this->getMedia('portfolios')->first()->getFullUrl();
        }
    }

    // protected static function boot()
    // {
    //     parent::boot();
    //     static::saved(function ($model) {
    //         if($model->status=='active' && $model->is_featured==true){
    //         self::where('designer_id' , $model->designer_id)
    //             ->where('status','active')
    //             ->where('attachment_type',$model->attachment_type)
    //             ->where('id','!=',$model->id)
    //             ->update(['is_featured' => false]);
    //         }
    //     });
    // }

}