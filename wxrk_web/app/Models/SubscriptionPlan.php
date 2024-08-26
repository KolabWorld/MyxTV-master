<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SubscriptionPlan extends Model
{

    use SoftDeletes;

    protected $fillable = [
        'name', 
        'plan_type', 
        'price', 
        'no_of_allowed_images', 
        'no_of_allowed_videos', 
        'offers_in_a_month', 
        'premium_days', 
        'description', 
        'status', 
        'created_by', 
        'updated_by'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
    */
    protected $hidden = [
        'deleted_at'
    ];

    public function createdBy()
    {
        return $this->belongsTo(Admin::class,);
    }

    public function updatedBy()
    {
        return $this->belongsTo(Admin::class,);
    }

    public function planType()
    {
        return $this->belongsTo(PlanType::class, 'plan_type_id');
    }

    public function adminSubscriptionPlans()
    {
        return $this->hasMany(AdminSubscriptionPlan::class);
    }
}
