<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PlanName extends Model
{
    use SoftDeletes;
    
    protected $fillable = [
        'plan_type_id', 
        'name', 
        'max_images_allowed', 
        'max_videos_allowed', 
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
        'deleted_at',
    ];

    public function createdBy() {
        return $this->belongsTo(Admin::class);
    }

    public function updatedBy() {
        return $this->belongsTo(Admin::class);
    }
    public function planType() {
        return $this->belongsTo(PlanType::class);
    }

}
