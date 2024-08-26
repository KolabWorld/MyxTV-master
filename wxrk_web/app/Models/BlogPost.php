<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;

class BlogPost extends Model implements HasMedia
{

    use SoftDeletes, HasMediaTrait;

    protected $fillable = [
        'category_id',
        'title',
		'description',
        'status', 
        'show_on_home', 
        'created_by', 
        'updated_by', 
        'admin_id', 
        'designer_id', 
        'user_id', 
        'created_at', 
        'updated_at'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var arraysequence
     */
    protected $hidden = ['deleted_at','featured_image'];

    public function createdBy(){
        return $this->belongsTo(Admin::class);
    }

    public function updatedBy(){
        return $this->belongsTo(Admin::class);
    }

    public function getCategory(){
        return $this->belongsTo(BlogCategory::class,'category_id');
    }

    public function getFeaturedImageAttribute()
    {

        if ($this->getMedia('featured_image')->isEmpty()) {
            return false;
        } else {
            return $this->getMedia('featured_image')->first()->getFullUrl();
        }
    }

}
