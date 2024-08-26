<?php
namespace App\Models;

use App\Helpers\ConstantHelper;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class NewsletterSubsciber extends Model
{

    use SoftDeletes;
    
    protected $table = 'newsletter_subscribers';

    protected $fillable = [
        'email', 
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
    */
    protected $hidden = [
        'deleted_at'
    ];
}
