<?php

namespace App\Entities;

use App\Repositories\Authorization\RoleRepo;

class SrvRoleEntity extends IRoleEntity
{
    public function __construct( RoleRepo $repository )
    {
        $this->repository = $repository;
    }
}