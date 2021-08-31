<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;
    protected $table = 'roles';

    public function model_has_role(){
        return $this->hasMany(ModelHasRole::class, 'role_id');
    }

    /**
     * 31/8
     * HungTM
     * start
     */
    public function users()
    {
        return $this->belongsToMany('App\User');
    }

    public function permissions()
    {
        return $this->belongsToMany(Permission::class, 'role_has_permissions');
    }

    public function assign(Permission $permission) //Gives permission to a role.
    {
        return $this->permissions()->save($permission);
    }
    /**
     * 31/8
     * HungTM
     * end
     */
}
