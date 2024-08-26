<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EventSponser extends Model
{

    protected $table = 'event_sponser';

    protected $fillable = [
        'event_id', 
        'sponser_id', 
        'admin_id'
    ];

    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    public function sponser()
    {
        return $this->belongsTo(Sponser::class);
    }

    public function admin()
    {
        return $this->belongsTo(Admin::class);
    }

}
