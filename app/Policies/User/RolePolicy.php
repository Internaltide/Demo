<?php

namespace App\Policies\User;

use App\User;
use App\Policies\GlobalPolicy;
use App\Services\Auth\PermissionService;
use Illuminate\Auth\Access\HandlesAuthorization;

class RolePolicy extends GlobalPolicy
{
    use HandlesAuthorization;

    public $domainAlias = 'permission';
    protected $hidden = true;
    protected $requireBase = false;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct(PermissionService $permSrv)
    {
        parent::__construct($permSrv);
    }

    public function abilityGet()
    {
        return [
            'entry' => 'entry',
            'assignUser' => 'assignUsers',
            'assignPrivi' => 'assignPrivileges',
            'createRole' => 'createRole',
            'updateRole' => 'updateRole',
            'deleteRole' => 'deleteRole',
            'updatePrivi' => 'updatePrivilege'
        ];
    }

    public function entry()
    {
        return $this->permSrv->isAuthorizer();
    }

    public function createRole()
    {
        return $this->permSrv->isAuthorizer();
    }

    public function assignUsers(User $user, $role_name)
    {
        if( $this->permSrv->isAuthorizer() && !in_array($role_name, $this->permSrv->roleCanNotAccessByNoneAdmin()) ){
            return true;
        }
        return false;
    }

    public function assignPrivileges(User $user, $role_name)
    {
        if( $this->permSrv->isAuthorizer() && !in_array($role_name, $this->permSrv->roleCanNotAccessByNoneAdmin()) ){
            return true;
        }
        return false;
    }

    public function updateRole(User $user, $role_name)
    {
        if( $this->permSrv->isAuthorizer() && !in_array($role_name, $this->permSrv->roleCanNotAccessByNoneAdmin()) ){
            return true;
        }
        return false;
    }

    public function deleteRole(User $user, $role_name)
    {
        if( $this->permSrv->isAuthorizer() && !in_array($role_name, $this->permSrv->roleCanNotAccessByNoneAdmin()) ){
            return true;
        }
        return false;
    }

    public function updatePrivilege(User $user, $privilege_name)
    {
        return $this->permSrv->isAuthorizer();
    }
}
