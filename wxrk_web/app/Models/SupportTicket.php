<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;

class SupportTicket extends Model implements HasMedia
{
    use SoftDeletes, HasMediaTrait;

    protected $fillable = [
        'category_id', 
        'sub_category_id', 
        'subject', 
        'description', 
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
        'attachments' 
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

    public function getAttachmentsAttribute()
    {
        if ($this->getMedia('attachments')->isEmpty()) {
            return [];
        } else {
            $media =  $this->getMedia('attachments')->all();
            $images = [];
            foreach ($media as $image) {
                $image->full_url = $image->getFullUrl();
                $images[] = $image;
            }
            return $images;
        }
    }

    public function chats()
    {
        return $this->hasMany(SupportChat::class);
    }

    public function firstChat()
    {
        $admin = Admin::whereHas('roles', function($q){
            $q->where('alias', 'admin');
        })->first();

        if($admin){
            return $this->hasOne(SupportChat::class)
                ->where('created_by', $admin->id);
        }
    }
}