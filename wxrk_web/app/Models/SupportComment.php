<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;

class SupportComment extends Model implements HasMedia
{
    use SoftDeletes, HasMediaTrait;

    protected $fillable = [
        'remark', 
        'status',
        'created_by',
        'updated_by'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var arraysequence
     */
    protected $hidden = [
        'deleted_at',
    ];

    protected $appends = [
        'attachment' 
    ];

    public function createdBy()
    {
        return $this->belongsTo(Admin::class, 'created_by');
    }

    public function updatedBy()
    {
        return $this->belongsTo(Admin::class);
    }

    public function deletedBy()
    {
        return $this->belongsTo(Admin::class);
    }

    public function getAttachmentAttribute()
    {
        if ($this->getMedia('attachment')->isEmpty()) {
            return false;
        } else {
            return $this->getMedia('attachment')->first()->getFullUrl();
        }
    }
}