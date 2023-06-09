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
        return $this->belongsToMany('App\Models\Role')->withPivot('enterprise_part_id');
    }

    public function permissions()
    {
        return $this->belongsToMany('App\Models\Permission')->withPivot('enterprise_parts');
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
        $parts = [];
        $role_name = str_replace('%', '', $name);

        foreach ($this->roles as $role) {
            if (gettype(strpos($name, '%')) == 'boolean' && $role->name == $name) {
                return true;
            } elseif (startsWith($name, '%') && endsWith($name, '%') && gettype(strpos($role->name, $role_name)) != 'boolean') {
                $parts[] = $role->pivot->enterprise_part_id;
            } elseif (startsWith($name, '%') && startsWith($role->name, $role_name)) {
                $parts[] =  $role->pivot->enterprise_part_id;
            } elseif (endsWith($role->name, $role_name)) {
                $parts[] =  $role->pivot->enterprise_part_id;
            }
        }

        return sizeof($parts) == 0 ? false : $parts;
    }

    public function hasPermission($type, $name)
    {
        foreach ($this->permissions as $permission) {
            if ($permission->type == $type && $permission->name == $name) {
                return is_null($permission->pivot->enterprise_parts) ?
                        true : $permission->pivot->enterprise_parts;
            }
        }

        return false;
    }
}
