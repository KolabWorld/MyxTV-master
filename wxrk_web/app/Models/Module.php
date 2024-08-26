<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Module extends Model
{

    use SoftDeletes;

    protected $fillable = [
        'title',
        'alias',
        'order',
        'description',
        'icon'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var arraysequence
     */
    protected $hidden = ['deleted_at'];

    public function designerModules()
    {
        return $this->hasMany(DesignerModule::class);
    }
}