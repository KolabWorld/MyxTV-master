<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Sponser extends Model
{

    use SoftDeletes;

    protected $fillable = [
        'name', 
        'email', 
        'mobile', 
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
        return $this->belongsToMany(Event::class);
    }

}
