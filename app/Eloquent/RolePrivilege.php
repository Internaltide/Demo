<?php

namespace App\Eloquent;

use Illuminate\Database\Eloquent\Model;

class RolePrivilege extends Model
{
    protected $table = 'dm_role_privilege';

    protected $connection = 'domain';

    protected $primaryKey = 'id';
    protected $keyType = 'integer';
    protected $dateFormat = 'Y/m/d H:i:s';
    public $incrementing = true;

    protected $guarded = [];
    protected $hidden = [];
}
