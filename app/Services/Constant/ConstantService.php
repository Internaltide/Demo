<?php

namespace App\Services\Constant;

use App\IManageService;

// TODO: 仿 Laravel Facade 方式進行改寫
class ConstantService extends IManageService
{

    public static $constSet = [];

    public function __construct()
    {
        // do nothing
    }

    // 一次定義一組常數
    public static function loadConstant($group,$mode='define')
    {
        switch($group){
            case 'ROLE_TYPE':
                ConstantService::define('ROLE_GENERAL', 0, $mode);
                ConstantService::define('ROLE_SERVICE', 1, $mode);
                ConstantService::define('ROLE_SYSTEM', 2, $mode);
                break;
            case 'ROLE_BUILTIN':
                ConstantService::define('SYSROLE_ADMIN', 'Administrator', $mode);
                ConstantService::define('SYSROLE_AUTHORIZER', 'Authorizer', $mode);
                break;
            default:
                if( empty($group) ){
                    dd("Constant Group $group Not Defined!!");
                } else {
                    dd("Constant Group $group Not Exists!!");
                }
                break;
        }
    }

    // 一次定義多組常數
    public static function loadConstants($groupArr)
    {
        if( is_array($groupArr) ){
            foreach($groupArr as $constantGroup){
                ConstantService::loadConstant($constantGroup);
            }
        }
    }

    public static function getConstSet($group)
    {
        ConstantService::loadConstant($group,'skeleton');
        $constSet = ConstantService::$constSet;
        ConstantService::$constSet = [];
        return $constSet;
    }

    public static function define($name,$val,$mode='define')
    {
        if( $mode==='define' ){
            if( !defined($name) ) define($name,$val);
        } else if( $mode==='skeleton' ) {
            array_push(
                ConstantService::$constSet, [
                    'name'  => $name,
                    'val'   => $val
                ]
            );
        }
    }

    public static function printConstant($constantName)
    {
        if( defined($constantName) ){
            echo "Constant Value: ".$constantName;
        } else {
            echo "Constant Not Exists!!";
        }
    }
}