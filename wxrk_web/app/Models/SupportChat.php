<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;

class SupportChat extends Model implements HasMedia
{
    use SoftDeletes, HasMediaTrait;

    protected $fillable = [
        'support_ticket_id',
        'message',
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
        'attachment',
        'formatted_created_at'
    ];

    public function createdBy()
    {
        return $this->belongsTo(Admin::class, 'created_by');
    }

    public function updatedBy()
    {
        return $this->belongsTo(Admin::class, 'created_by');
    }

    public function category()
    {
        return $this->belongsTo(SupportCategory::class);
    }

    public function subCategory()
    {
        return $this->belongsTo(SupportCategory::class);
    }

    public function getAttachmentAttribute()
    {

        if ($this->getMedia('attachment')->isEmpty()) {
            return false;
        } else {
            return $this->getMedia('attachment')->first()->getFullUrl();
        }
    }

    public function getFormattedCreatedAtAttribute()
    {
        return date('y M d, h:i a',strtotime($this->created_at));
    }
}
