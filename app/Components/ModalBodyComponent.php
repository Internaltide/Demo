<?php

namespace App\Components;

use App\Mediator;
use App\Entities\IRoleEntity;
use App\Entities\PrivilegeEntity;
use App\Repositories\User\UserRepo;
use App\Repositories\Authorization\RoleRepo;
use App\Repositories\Authorization\PrivilegeRepo;
use App\Traits\EntityFetchTrait;

// TODO: 將 component view 移到 components 目錄下
class ModalBodyComponent
{
    use EntityFetchTrait;

    private $policyAssign;
    private $userRepo;
    private $roleRepo;
    private $privilegeRepo;

    public function __construct( UserRepo $userRepo,
                                                  RoleRepo $roleRepo,
                                                  PrivilegeRepo $privilegeRepo )
    {
        $this->mediator = Mediator::instance();

        $this->userRepo = $userRepo;
        $this->roleRepo = $roleRepo;
        $this->privilegeRepo = $privilegeRepo;
    }

    public function userCheckboxUnderRole($name, $postUrl)
    {
        // Get All Users
        $allUsers = $this->userRepo->getUsers();

        if( !$this->mediator->ifCurrentLoginIsAdmin() ){
            // Get Exclude Users
            $excludeUser = $this->roleRepo->getRoleUsers([
                'Administrator',
                'Authorizer'
            ]);

            // 將 Exclude Users 從清單中排除
            $allUsers = $allUsers->reject(function ($value, $key) use($excludeUser) {
                return in_array($value->user_id, $excludeUser);
            });
        }

        // Get Assigned Users
        $usersUnderRole = $this->roleRepo->getRoleUsers($name);

        return view('themes.default.role.usersAssign', [
            'actionUrl' => $postUrl,
            'all' => $allUsers,
            'assigned' => $usersUnderRole,
            'rolename' => $name
        ]);
    }

    public function privilegeCheckboxUnderRole($name, $excludeDomain, $postUrl)
    {
        // 先取得所有所有權限，再將欲排除的部分從資料集中排除
        $excludeDomain = "(" . implode('|', array_wrap($excludeDomain)) . ")";
        $allPrivileges = $this->privilegeRepo->getPrivileges()->reject(function ($value, $key) use($excludeDomain) {
            return (preg_match('/^' . $excludeDomain . '.[a-zA-Z]+$/', $value->privilege_name)) ? true:false;
        });

        // Get Assigned Privileges
        $privilegesUnderRole = $this->roleRepo->getRolePrivileges($name);


        return view('themes.default.role.privilegeAssign', [
            'actionUrl' => $postUrl,
            'all' => $allPrivileges,
            'assigned' => $privilegesUnderRole,
            'rolename' => $name
        ]);
    }

    public function updateRoleForm($name, $postUrl)
    {
        $entity = $this->entity('role', $name);

        return view('themes.default.role.roleUpdate', [
            'actionUrl' => $postUrl,
            'role' => $entity->getModel()
        ]);
    }

    public function updatePrivilegeForm($name, $postUrl)
    {
        $entity = $this->entity(PrivilegeEntity::class, $name);

        return view('themes.default.role.privilegeUpdate', [
            'actionUrl' => $postUrl,
            'privilege' => $entity->getModel()
        ]);
    }

    public function createRolesForm($postUrl)
    {
        return view('themes.default.role.rolesCreate', [
            'actionUrl' => $postUrl
        ]);
    }
}