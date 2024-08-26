<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TwitchVideosStreamer extends Model
{
    protected $fillable = [
        'twitch_video_id', 
        'user_id', 
        'video_duration', 
        'watching_duration', 
        'current_watching_duration', 
        'coin', 
        'status'
    ];
    
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var arraysequence
     */
    protected $hidden = [
        'deleted_at'
    ];

    public function twitchVideo() {
        return $this->belongsTo(TwitchVideo::class);
    }

    public function user() {
        return $this->belongsTo(User::class);
    }
    
}
