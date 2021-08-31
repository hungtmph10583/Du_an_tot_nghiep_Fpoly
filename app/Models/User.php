<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles;
    protected $table = 'users';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'avatar',
        'password',
        'phone',
        'active',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function personal_information(){
        return $this->hasMany(PersonalInformation::class, 'user_id');
    }

    public function model_has_role(){
        return $this->hasMany(ModelHasRole::class, 'model_id');
    }

    public function role(){
        return $this->bolongsTo(Role::class);
    }

    /**
     * 21-08-31
     * HungTM
     * Start
     */
    // public function roles(){
    //     return $this->hasOne('App\Role');
    // }

    // public function hasRole($role){
    //     if (is_string($role)) {
    //         return $this->roles->contains('name', $role);
    //     }

    //     return (bool) $role->intersect($this->roles)->count();
    // }

    // public function assignRole($role)
    // {
    //     if (is_string($role)) {
    //         return $this->roles()->save(
    //             Role::whereName($role)->firstOrFail()
    //         );
    //     }

    //     return $this->roles()->save($role);
    // }
    /**
     * 21-08-31
     * HungTM
     * End
     */
}
