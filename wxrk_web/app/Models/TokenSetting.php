<?php

namespace App\Models;
use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TokenSetting extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'value',
        'status'
    ];

    protected $hidden = [
        'deleted_at'
    ];

    public function createdBy()
    {
        return $this->belongsTo(Admin::class);
    }

    public function updatedBy()
    {
        return $this->belongsTo(Admin::class);
    }
}
