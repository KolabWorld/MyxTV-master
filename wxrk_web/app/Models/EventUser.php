<?php
namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class EventUser extends Model
{

    protected $table = 'event_user';

    protected $fillable = [
        'event_id', 
        'user_id', 
        'created_at', 
        'updated_at'
    ];

    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
