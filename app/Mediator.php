<?php

namespace App;

use App;
use App\Manages\PermissionManage;
use App\Services\Constant\ConstantService;
use App\Services\Auth\PermissionService;

class Mediator
{
    private static $instance = null;

    /**
     * 領域層管理物件
     */
    //private $domainManage = null;
    //private $applicationManage = null;
    private $permManage = null;
    //private $configManage = null;
    //private $userManage = null;

    /**
     * 服務物件
     */
    private $permSrv = null;

    private function __construct()
    {
        // do nothing
    }

    private function initial()
    {
        $this->permManage = App::make(App\Manages\PermissionManage::class);
        $this->permSrv = App::make(App\Services\Auth\PermissionService::class);
    }

    public static function instance()
    {
        if( self::$instance === null ){
            self::$instance = new Mediator();
            self::$instance->initial();
        }

        return self::$instance;
    }

    public function setManage()
    {
        //
    }

    public function loadConsts($group)
    {
        ConstantService::loadConstants($group);
    }

    public function ifCurrentLoginIsAdmin()
    {
        return $this->permSrv->isAdmin();
    }
}
