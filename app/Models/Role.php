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

    public function permissions()
    {
        return $this->belongsToMany('App\Models\Permission');
    }
}
