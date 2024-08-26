<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SupportCategory extends Model
{

    use SoftDeletes;

    protected $fillable = [
        'name', 
        'parent_id', 
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

    public function parent(){
        return $this->belongsTo(SupportCategory::class);
    }

    public function childs(){
        return $this->belongsTo(SupportCategory::class, 'parent_id', 'id');
    }
}
