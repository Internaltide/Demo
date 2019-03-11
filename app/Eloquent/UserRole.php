<?php

namespace App\Eloquent;

use Illuminate\Database\Eloquent\Model;

class UserRole extends Model
{
    protected $table = 'dm_user_role';

    protected $connection = 'domain';

    protected $primaryKey = 'id';
    protected $keyType = 'integer';
    protected $dateFormat = 'Y/m/d H:i:s';
    public $incrementing = true;

    protected $guarded = [];
    protected $hidden = [];

    public function ownPrivileges()
    {
        return $this->hasMany('App\Eloquent\RolePrivilege', 'role_name', 'role_name');
    }
}
