<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SubscriptionPlanLog extends Model
{

    use SoftDeletes;

    protected $fillable = [
        'name', 
        'plan_type', 
        'subscription_plan_id', 
        'admin_id',
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
        return $this->belongsTo(SubscriptionPlan::class);
    }

    public function admin()
    {
        return $this->hasMany(Admin::class,);
    }
}
