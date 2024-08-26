<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Home extends Model
{

    use SoftDeletes;

    protected $fillable = [
        'type', 
        'designer_id', 
        'content', 
        'status'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var arraysequence
     */
    protected $hidden = ['deleted_at'];

    public function designer()
    {
        return $this->belongsTo(Designer::class);
    }

    public function homeFeatures()
    {
        return $this->hasMany(HomeFeature::class, 'home_id');
    }

    public function products()
    {
        return $this->belongsToMany(Product::class, HomeFeature::class);
    }

}
