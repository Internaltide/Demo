<?php

namespace App\Entities;

use App\Entities\IEntity;
use App\Exceptions\ActionException;
use App\Repositories\Authorization\PrivilegeRepo;

class PrivilegeEntity extends IEntity
{
    public function __construct(PrivilegeRepo $repository)
    {
        $this->repository = $repository;
    }

    public function group()
    {
        return [];
    }

    public function find($key)
    {
        $this->eloquent = $this->repository->getPrivilege($key);
        return $this;
    }

    public function savedata($data)
    {
        if( empty($data) || !is_array($data) ) return false;

        if( array_key_exists('name', $data) ) $this->eloquent->label = $data['name'];
        if( array_key_exists('description',$data) ) $this->eloquent->description = $data['description'];

        $this->repository->savePrivilege($this->eloquent);
    }

    public function destroy($excute=true)
    {
        if( $excute === true ){
            $this->repository->deletePrivilege($this->eloquent);
        }
    }
}