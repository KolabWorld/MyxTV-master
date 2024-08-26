<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DayWisePoolMaster extends Model
{
    use SoftDeletes;
    
    protected $fillable = [
        'pool_master_id', 
        'pool_date', 
        'pool_balance', 
        'daily_limit', 
        'total_user', 
        'wxrk_dist_limit', 
        'wxrk_per_user_per_day', 
        'wxrk_per_min', 
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

    public function poolMaster() {
        return $this->belongsTo(PoolMaster::class);
    }

    public function createdBy() {
        return $this->belongsTo(Admin::class);
    }

    public function updatedBy() {
        return $this->belongsTo(Admin::class);
    }

}
