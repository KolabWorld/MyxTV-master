<?php

namespace App\Models;
use App\User;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Country extends Model
{
    use SoftDeletes;

    protected $table = 'countries';

    protected $fillable = [
        'name', 
        'code', 
        'dial_code', 
        'created_at', 
        'updated_at'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var arraysequence
     */
    protected $hidden = ['deleted_at'];


    public function addresses()
    {
        return $this->hasMany(Address::class, 'country_id');
    }

    public function users()
    {
        return $this->hasMany(User::class,'country_id');
    }

    public function offers()
    {
        return $this->belongsToMany(Offer::class);
    }

    public function events()
    {
        return $this->belongsToMany(Event::class);
    }

}
