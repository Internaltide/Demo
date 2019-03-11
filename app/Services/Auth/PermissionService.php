<?php

namespace App\Services\Auth;

use Auth;
use App\Repositories\User\UserRepo;
use App\Repositories\Authorization\RoleRepo;
use App\Repositories\Authorization\PrivilegeRepo;

/**
 * 處理各種授權檢查判斷
 */
class PermissionService
{
    private $cacheName = 'USERPERM';

    private $userRepo;
    private $roleRepo;
    private $privilegeRepo;

    public function __construct( UserRepo $userRepo,
                                                  RoleRepo $roleRepo,
                                                  PrivilegeRepo $privilegeRepo )
    {
        $this->userRepo = $userRepo;
        $this->roleRepo = $roleRepo;
        $this->privilegeRepo = $privilegeRepo;
    }

    public function isAdmin()
    {
        // Get current authticated user id
        $user_id = Auth::user()->user_id;

        $userRoles = $this->userRepo->getUserRoles($user_id);

        return ( in_array('Administrator',$userRoles) ) ? true:false;
    }

    public function isAuthorizer()
    {
        // Get current authticated user id
        $user_id = Auth::user()->user_id;

        $userRoles = $this->userRepo->getUserRoles($user_id);

        return ( in_array('Authorizer',$userRoles) ) ? true:false;
    }

    public function ifActionPermited($action)
    {
        if ( session($this->cacheName) ) {
            $ownPrivileges = unserialize(session($this->cacheName));
        } else {
            // Get current authticated user id
            $user_id = Auth::user()->user_id;

            $ownPrivileges = $this->userRepo->getUserOwnPrivileges($user_id);
            $this->cache($ownPrivileges);
        }

        return ( in_array($action, $ownPrivileges) ) ? true:false;
    }

    public function cache($perm)
    {
        $data = serialize($perm);
        session([$this->cacheName => $data]);
    }

    /**
     * 重新生成並快取登入用戶的權限資料
     *
     * @return void
     */
    public function recache()
    {
        // Remove First
        session()->forget($this->cacheName);

        // Get current authticated user id
        $user_id = Auth::user()->user_id;

        // Recache Permission Data
        $this->cache(
            $this->userRepo->getUserOwnPrivileges($user_id)
        );
    }

    public function roleCanNotAccessByNoneAdmin()
    {
        return ['Administrator','Authorizer'];
    }
}