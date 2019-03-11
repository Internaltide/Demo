<?php

namespace App\Entities;

use App\Repositories\Authorization\RoleRepo;

class SysRoleEntity extends IRoleEntity
{
    public function __construct( RoleRepo $repository )
    {
        $this->repository = $repository;
    }

    public function atLeastOneUser()
    {
        return ( in_array($this->eloquent->role_name, [SYSROLE_ADMIN]) ) ? true:false;
    }
}