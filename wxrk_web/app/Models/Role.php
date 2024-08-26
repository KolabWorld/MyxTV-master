<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Role extends Model
{

    use SoftDeletes;

    protected $table = 'roles';

    protected $fillable = [
        'name', 'alias', 'order',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var arraysequence
     */
    protected $hidden = ['deleted_at'];

    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    public function permissions()
    {//dd($this->belongsToMany(Permission::class, 'role_permission'));
        return $this->belongsToMany(Permission::class, 'role_permission');
    }

    public function can($permission) {
        $permission = explode('.', $permission, 2);
        return !$this->permissions->filter(function($item) use($permission) {
            if($item->name == $permission[0] && $item->type == 'admin') { return true; }
            if (!isset($permission[1])) {
                return false;
            }
            if($item->name == $permission[0] && $item->type == $permission[1]) { return true; }
            return false;
        })->isEmpty();
    }

}
