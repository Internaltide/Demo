<?php

namespace App\Providers;

use App; // 拿掉會造成 Binding 失效，滿奇怪的，待查!!
use Blade;
use Illuminate\Support\ServiceProvider;
use App\Services\Constant\ConstantService;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // 定義 Blade 元件別名
        Blade::component('themes.default.components.pagetitle', 'pagetitle');
        Blade::component('themes.default.components.accordionPanel', 'accordionPanel');
        Blade::component('themes.default.components.modal', 'modal');

        // 常數載入
        ConstantService::loadConstants([
            'ROLE_TYPE'
        ]);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        // 定義 Manage Binding
        $this->app->when(App\Http\Controllers\User\RoleController::class)
            ->needs(App\IManageService::class)
            ->give(function ($app) {
                return $app->make(App\Manages\PermissionManage::class);
            });
    }
}
