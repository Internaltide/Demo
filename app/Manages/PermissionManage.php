<?php

namespace App\Manages;

use App\IManageService;
use App\Entities\IRoleEntity;
use App\Entities\PrivilegeEntity;
use App\Exceptions\ActionException;
use App\Repositories\Authorization\RoleRepo;
use App\Repositories\Authorization\PrivilegeRepo;

class PermissionManage extends IManageService
{
    private $roleRepo;
    private $privilegeRepo;

    public function __construct( RoleRepo $roleRepo,
                                                  PrivilegeRepo $privilegeRepo )
    {
        parent::__construct();

        $this->roleRepo = $roleRepo;
        $this->privilegeRepo = $privilegeRepo;
    }

    public function getAllRoles()
    {
        return $this->roleRepo->getRoles();
    }

    public function getAllPrivileges()
    {
        return $this->privilegeRepo->getPrivileges();
    }

    public function updateRoleUsersPivot($name, $newUserList)
    {
        // Get entity
        $entity = $this->entity('role', $name);

        if( $entity->atLeastOneUser() && empty($newUserList) ) throw new ActionException('At Least One Assign User', 10002);

        // Wrap variable newUserList
        $newUserList = array_wrap($newUserList);

        // Get Assigned Users
        $assigned = $this->roleRepo->getRoleUsers($name);

        // Deal with new assign
        $entity->assignUsers(
            array_diff($newUserList, $assigned)
        );

        // Deal with remove
        $entity->removeAssignedUsers(
            array_diff($assigned, $newUserList)
        );
    }

    public function updateRolePrivilegesPivot($name, $newPrivilegeList)
    {
        // Get entity
        $entity = $this->entity('role', $name);

        // Wrap variable newUserList
        $newPrivilegeList = array_wrap($newPrivilegeList);

        // Get Assigned Privileges
        $assigned = $this->roleRepo->getRolePrivileges($name);

        // Deal with new assign
        $entity->assignPrivileges(
            array_diff($newPrivilegeList, $assigned)
        );

        // Deal with remove
        $entity->removeAssignedPrivileges(
            array_diff($assigned, $newPrivilegeList)
        );
    }

    public function createRoles($roledata)
    {
        $allRoles = array_pluck($this->getAllRoles()->toArray(), 'role_name');

        // 排除重複資料
        $roledata = array_except($roledata,
            array_search_unique($roledata, 'role_name')
        );

        // Data Key 檢查，排除掉已經存在於資料庫的
        $filtered = array_where($roledata, function($value, $key) use($allRoles){
            return !in_array($value['role_name'], $allRoles);
        });

        if( empty($filtered) ) throw new ActionException('Duplicated Role Found', 10001);

        $this->roleRepo->batchInsert($filtered);

        if( sizeof($filtered) <> sizeof($roledata) ) throw new ActionException('Certain Duplicated Role Found', 11001);
    }

    public function updateRoleInfo($name, $information)
    {
        // Get entity
        $entity = $this->entity('role', $name);

        return $entity->savedata($information);
    }

    public function updatePrivilegeInfo($name, $information)
    {
        // Get entity
        $entity = $this->entity(PrivilegeEntity::class, $name);

        return $entity->savedata($information);
    }

    public function deleteRoles($names)
    {
        if( !is_array($names) ){
            // Single record delete
            $entity = $this->entity('role', $names);
            $entity->destroy();
        } else {
            // Multi record batch delete
            $stacks = [];
            foreach($names as $name){
                $entity = $this->entity('role', $names);
                if( $entity->destroy(false) ) array_push($stacks, $name);
            }

            // 若選擇的資料皆不允許刪除
            if( empty($stacks) ) throw new ActionException('Cant Remove System Role', 10003);

            // 批次仍交由 Repository 做一次性處理，避免多次查詢
            $this->roleRepo->batchDelete($stacks);
        }
    }
}