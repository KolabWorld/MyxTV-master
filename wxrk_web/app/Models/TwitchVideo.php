<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TwitchVideo extends Model
{
    protected $fillable = [
        'twitch_id', 
        'stream_id', 
        'user_id', 
        'user_login', 
        'user_name', 
        'title', 
        'description', 
        'url', 
        'thumbnail_url', 
        'viewable', 
        'view_count', 
        'language', 
        'type', 
        'duration', 
        'muted_segments', 
        'video_created_at', 
        'video_published_at', 
        'status'
    ];
    
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
    */
    
}
