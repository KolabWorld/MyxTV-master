<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AdminSubscriptionPlan extends Model
{

    use SoftDeletes;

    protected $fillable = [
        'name', 
        'plan_type', 
        'admin_id',
        'subscription_plan_id', 
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

    public function subscriptionPlan()
    {
        return $this->hasMany(SubscriptionPlan::class,);
    }

    public function admin()
    {
        return $this->hasMany(Admin::class,);
    }
}
