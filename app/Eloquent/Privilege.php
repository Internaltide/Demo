<?php

namespace App\Eloquent;

use Illuminate\Database\Eloquent\Model;

class Privilege extends Model
{
    protected $table = 'dm_privilege';

    protected $connection = 'domain';

    protected $primaryKey = 'privilege_name';
    protected $keyType = 'string';
    public $timestamps = false;
    public $incrementing = false;

    protected $guarded = [];
    protected $hidden = [];

    /**
     * get all roles that can access certain privilege
     *
     * @return object
     */
    public function allowRoles()
    {
        return $this->belongsToMany('App\Eloquent\Role', 'dm_role_privilege', 'privilege_name', 'role_name')
                          ->withPivot('created_at', 'updated_at')->withTimestamps();
    }
}
