<?php

namespace App\Policies;

use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

// Privilege 已合併到 Permission 模組處理，權限管理並到RolePolicy內處理
class PrivilegePolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct(PermissionService $permSrv)
    {
        parent::__construct($permSrv);
    }
}
