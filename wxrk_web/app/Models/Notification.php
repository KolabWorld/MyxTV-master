<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;

class Notification extends Model implements HasMedia
{
	use SoftDeletes, HasMediaTrait;

    protected $fillable = [
        'equipment_detail_type',
        'equipment_detail_id',
        'admin_type',
        'admin_id',
        'status',
        'description',
        'mark_as_read',
        'created_by'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'deleted_at',
    ];

    public function admin() {
      return $this->belongsTo(Admin::class);
    }
    public function equipmentDetail() {
       return $this->belongsTo(EquipmentDetail::class, 'equipment_detail_id');
    }

    public function adminMapping() {
      return $this->hasOne(NotificationAdminMapping::class, 'notification_id')->where('admin_id',\Auth::user()->id);
    }

    public function adminMappings() {
      return $this->hasMany(NotificationAdminMapping::class, 'notification_id');
    }

    public function createdBy() {
      return $this->belongsTo(Admin::class);
    }
}


