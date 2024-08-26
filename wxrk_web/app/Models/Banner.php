<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;

class Banner extends Model  implements HasMedia
{

    use SoftDeletes, HasMediaTrait;
    
    protected $fillable = [
        'type', 
        'name', 
        'button_text', 
        'button_link', 
        'attachment_type',
        'is_auto_play',
        'status', 
        'created_by', 
        'updated_by'
    ];
    
    protected $appends = ['image'];
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
    */
    protected $hidden = [
        'media',
        'deleted_at',
    ];

    public function createdBy() {
        return $this->belongsTo(Admin::class);
    }

    public function updatedBy() {
        return $this->belongsTo(Admin::class);
    }

    public function registerMediaCollections()
	{
		$this->addMediaCollection('image')
			->singleFile();
    }

    public function getImageAttribute()
    {

		if($this->getMedia('image')->isEmpty()) {
			return false;
		}
		else {
			return $this->getMedia('image')->first()->getFullUrl();
		}
    }

}
