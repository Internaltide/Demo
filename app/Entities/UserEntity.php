<?php

namespace App\Entities;

use App\Repositories\User\UserRepo;

class UserEntity extends IEntity
{
    public function __construct( UserRepo $repository )
    {
        $this->repository = $repository;
    }

    public function group()
    {
        return [];
    }

    public function find($key)
    {
        $this->eloquent = $this->repository->getUser($key);
        return $this;
    }

    public function createdata($data)
    {
        //
    }

    public function savedata($data)
    {
        //
    }

    public function destroy($excute=true)
    {
        //
    }
}