<?php

namespace App\Traits;

use App;

trait EntityFetchTrait
{
    public function entity($classOrType, $key)
    {
        // 取得對應介面並處理綁定
        $class = $this->parseFromMapping($classOrType);
        $method = $this->bindingMethod($classOrType, $key);
        if( !empty($method) ){
            $eloquent = App::call(static::class . $method, [
                'class' => $class,
                'key' => $key
            ]);
        }

        // 解析實體物件(without eloquent)
        $entity = App::make($class);

        // 載入實體物件所需常數
        $this->mediator->loadConsts(
            $entity->group()
        );

        // 返回實體物件(with eloquent)
        if( isset($eloquent) ){
            $entity->setModel($eloquent);
            return $entity;
        } else {
            return $entity->find($key);
        }
    }

    private function runVistor($vistorCallback)
    {
        $mapping = [
            'role' => App\Entities\IRoleEntity::class,
        ];

        return $vistorCallback($mapping);
    }

    private function parseFromMapping($type)
    {
        // Return Interface if exist
        return $this->runVistor(function($mapping) use($type){
            return isset($mapping[$type]) ? $mapping[$type]:$type;
        });
    }

    private function bindingMethod($type, $key)
    {
        return $this->runVistor(function($mapping) use($type, $key){
            if( isset($mapping[$type]) ){
                return "@{$type}Entity";
            }
        });
    }

    public function roleEntity(App\Repositories\Authorization\RoleRepo $roleRepo, $class, $key)
    {
        $eloquent = $roleRepo->getRole($key);
        $role_type =  $eloquent->role_type;

        switch($role_type){
            case ROLE_SYSTEM:
                $concrete = App\Entities\SysRoleEntity::class;
                break;
            case ROLE_SERVICE:
                $concrete = App\Entities\SrvRoleEntity::class;
                break;
            case ROLE_GENERAL:
                $concrete = App\Entities\RoleEntity::class;
                break;
            default:
                // no default
                break;
        }
        App::bind($class, $concrete);

        return $eloquent;
    }
}