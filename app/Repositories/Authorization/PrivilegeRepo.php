<?php

namespace App\Repositories\Authorization;

use App\Eloquent\Privilege;
use App\Traits\CacheableTrait;
use App\Traits\RepositoryTrait;

class PrivilegeRepo
{
    use CacheableTrait;
    use RepositoryTrait;

    private $model;

    public function __construct(Privilege $privilege)
    {
        $this->model = $privilege;
        $this->cacheStore();

        $this->cacheKey = [
            'PRIVILEGE_LIST' => $this->cachekey(1)
        ];
    }

    public function getPrivilege($privilegename)
    {
        return $this->model->find($privilegename);
    }

    public function getPrivileges()
    {
        return $this->store->remember($this->cacheKey['PRIVILEGE_LIST'], now()->addMonth(), function () {
            return $this->model->all();
        });
    }

    public function privileges()
    {
        return array_pluck($this->model->all()->toArray(), 'privilege_name');
    }

    public function getAllowRoles($privilege_name)
    {
        $query = $this->model->where('privilege_name', $privilege_name);

        return array_pluck($query->get()->first()->allowRoles->toArray(), 'role_name');
    }

    public function savePrivilege($eloquent)
    {
        $eloquent->save();

        $this->store->forget($this->cacheKey['PRIVILEGE_LIST']);
    }

    public function deletePrivilege($eloquent)
    {
        $eloquent->delete();

        $this->store->forget($this->cacheKey['PRIVILEGE_LIST']);
    }

    public function batchInsert($data)
    {
       $this->model->insert($data);

       $this->store->forget($this->cacheKey['PRIVILEGE_LIST']);
    }

    public function batchDelete($data)
    {
        $this->model->destroy($data);

        $this->store->forget($this->cacheKey['PRIVILEGE_LIST']);
    }
}