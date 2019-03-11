<?php

namespace App\Services\Auth;

use Illuminate\Http\Request;
use App\Repositories\User\UserRepo;

/**
 * 處理各種用來實作登入限制規則的方法
 * TODO: 可配置使用的限制規則，且可套用複數規則
 * TODO: 可配置的User Table啟用旗標名稱
 * TODO: 可配置的允許登入位置及函數實作
 * TODO: 完整度夠後，改成Package的方式用Composer引入，也方便管理依賴
 */
class LimitLoginService
{
    private $userRepo;

    public function __construct(UserRepo $userRepo)
    {
        $this->userRepo = $userRepo;
    }

    public function ifActiveLoginUser($loginName, $asTrueWhenNotExist=false)
    {
        $userAttemptLogin = $this->userRepo->getUserByLogin($loginName);

        if( is_null($userAttemptLogin) ) return $asTrueWhenNotExist;

        return ($userAttemptLogin->active==1) ? true:false;
    }

    public function ifAllowedCountry()
    {
        // Pendding
    }
}