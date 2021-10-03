<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    use HasFactory;
    protected $table = 'permissions';

    /**
     * 31/8
     * HungTM
     * start
     */
    public function roles(){
        return $this->bolongsToMany(Role::class, 'role_has_permissions');
    }
    /**
     * 31/8
     * HungTM
     * end
     */
}
