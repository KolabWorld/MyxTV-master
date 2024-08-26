<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PlanType extends Model
{
    use SoftDeletes;
    
    protected $fillable = [
        'name', 
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

}
