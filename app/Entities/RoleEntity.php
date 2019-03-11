<?php

namespace App\Entities;

use App\Repositories\Authorization\RoleRepo;

class RoleEntity extends IRoleEntity
{
    public function __construct( RoleRepo $repository )
    {
        $this->repository = $repository;
    }

    public function canDeleted()
    {
        return true;
    }
}