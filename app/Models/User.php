<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;
    use \App\Models\Concerns\UsesUuid;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'google_id',
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

    public function roles()
    {
        return $this->belongsToMany('App\Models\Role');
    }

    public function permissions()
    {
        return $this->belongsToMany('App\Models\Permission');
    }

    public function headOf()
    {
        return $this->hasMany('App\Models\EnterprisePart', 'user_id');
    }

    public function getIsHeadAttribute()
    {
        foreach ($this->roles as $key => $role) {
            if ($role->is_head) {
                return true;
            }
        }

        return false;
    }

    public function hasRole($name)
    {
        foreach ($this->roles as $role) {
            if ($role->name == $name) {
                return true;
            }
        }

        return false;
    }

    public function hasPermission($type, $name)
    {
        foreach ($this->permissions as $permission) {
            if ($permission->type == $type && $permission->name == $name) {
                return true;
            }
        }

        return false;
    }

    public function memberOf()
    {
        return $this->belongsToMany(EnterprisePart::class, 'enterprise_part_user', 'user_id', 'enterprise_part_id');
    }
}
