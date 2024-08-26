<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EventType extends Model
{

    use SoftDeletes;

    protected $fillable = [
        'name', 
        'status'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
    */
    protected $hidden = [
        'deleted_at'
    ];
    
    public function events()
    {
        return $this->hasMany(Event::class,);
    }
    
}
