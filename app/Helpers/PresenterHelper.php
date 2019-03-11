<?php

namespace App\Helpers;

use App\Services\Auth\PermissionService;

class PresenterHelper
{
    private $permSrv;

    public function __construct( PermissionService $permSrv )
    {
        $this->permSrv = $permSrv;
    }

    public function showPermbtn($role_type)
    {
        return ( !$this->permSrv->isAdmin() && $role_type===ROLE_SYSTEM ) ? false:true;
    }
}