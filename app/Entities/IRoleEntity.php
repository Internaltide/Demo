<?php

namespace App\Entities;

use App\Entities\IEntity;
use App\Exceptions\ActionException;

abstract class IRoleEntity extends IEntity
{
    public function group()
    {
        return ['ROLE_TYPE','ROLE_BUILTIN'];
    }

    public function find($key)
    {
        $this->eloquent = $this->repository->getRole($key);
        return $this;
    }

    public function savedata($data)
    {
        if( empty($data) || !is_array($data) ) return false;

        if( array_key_exists('name', $data) ) $this->eloquent->label = $data['name'];
        if( array_key_exists('description',$data) ) $this->eloquent->description = $data['description'];

        $this->repository->saveRole($this->eloquent);
    }

    public function destroy($excute=true)
    {
        if( !$this->canDeleted() ) throw new ActionException('Cant Remove System Role', 10003);

        if( $excute === true ){
            $this->repository->deleteRole($this->eloquent);
        }
    }

    public function assignUsers($users)
    {
        if(!empty($users)) $this->repository->assignUsersToRole($this->eloquent, $users);
    }

    public function removeAssignedUsers($users)
    {
        if(!empty($users)) $this->repository->removeUsersFromRole($this->eloquent, $users);
    }

    public function assignPrivileges($privileges)
    {
        if(!empty($privileges)) $this->repository->assignPrivilegesToRole($this->eloquent, $privileges);
    }

    public function removeAssignedPrivileges($privileges)
    {
        if(!empty($privileges)) $this->repository->removePrivilegesFromRole($this->eloquent, $privileges);
    }

    /**
     * 判斷該類型角色是否至少需要指派一名用戶
     *
     * @return boolean
     */
    public function atLeastOneUser()
    {
        return false;
    }

    /**
     * 判斷該類型角色可否被使用者刪除
     *
     * @return boolean
     */
    public function canDeleted()
    {
        return false;
    }
}