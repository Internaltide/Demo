<?php

namespace App\Repositories\Authorization;

use App\Eloquent\Role;
use App\Traits\CacheableTrait;
use App\Traits\RepositoryTrait;

class RoleRepo
{
    use CacheableTrait;
    use RepositoryTrait;

    private $model;

    public function __construct( Role $role )
    {
        $this->model = $role;
        $this->cacheStore();

        $this->cacheKey = [
            'ROLE_LIST' => $this->cachekey(0)
        ];
    }

    public function getRole($rolename)
    {
        return $this->model->find($rolename);
    }

    public function getRoles()
    {
        return $this->store->remember($this->cacheKey['ROLE_LIST'], now()->addMonth(), function () {
            return $this->model->all();
        });
    }

    public function assignUsersToRole($eloquent, $users)
    {
        $eloquent->users()->attach($users);
    }

    public function removeUsersFromRole($eloquent, $users)
    {
        $eloquent->users()->detach($users);
    }

    public function assignPrivilegesToRole($eloquent, $privileges)
    {
        $eloquent->privileges()->attach($privileges);
    }

    public function removePrivilegesFromRole($eloquent, $privileges)
    {
        $eloquent->privileges()->detach($privileges);
    }

    public function batchInsert($data)
    {
       $this->model->insert($data);

       $this->store->forget($this->cacheKey['ROLE_LIST']);
    }

    public function batchDelete($data)
    {
        $this->model->destroy($data);

        $this->store->forget($this->cacheKey['ROLE_LIST']);
    }

    public function saveRole($eloquent)
    {
        $eloquent->save();

        $this->store->forget($this->cacheKey['ROLE_LIST']);
    }

    public function deleteRole($eloquent)
    {
        $eloquent->delete();

        $this->store->forget($this->cacheKey['ROLE_LIST']);
    }

    public function getRoleUsers($roles)
    {
        $roles = array_wrap($roles);

        $users = [];
        $dataset = $this->model->whereIn('role_name', $roles)->with('users')->get();
        foreach($dataset as $role){
            foreach( $role->users as $user ){
                $users[] = $user->user_id;
            }
        }
        return $users;
    }

    public function getRolePrivileges($role)
    {
        $query = $this->model->where('role_name', $role);

        return array_pluck($query->get()->first()->privileges->toArray(), 'privilege_name');
    }
}