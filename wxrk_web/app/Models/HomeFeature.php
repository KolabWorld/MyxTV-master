<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HomeFeature extends Model
{
    public $timestamps = true;

	protected $fillable = [
        'home_id',
        'designer_id',
        'product_id',
        'created_at',
        'updated_at',
    ];

    public function home()
    {
        return $this->belongsTo(Home::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}