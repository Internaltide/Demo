<?php

namespace App\Repositories\User;

use DB;
use App\User;

class UserRepo
{

    private $model;

    public function __construct(User $user)
    {
        $this->model = $user;
    }

    public function getUser($user_id)
    {
        return $this->model->find($user_id);
    }

    public function getUsers()
    {
        return $this->model->all();
    }

    public function getUserByLogin($login,$domain=null)
    {
        $query = $this->model->where('login', $login);
        if( !empty($domain) ){
            $query = $query->where('user_domain', $domain);
        }
        return $query->get()->first();
    }

    public function getUserRoles($user_id)
    {
        $query = $this->model->where('user_id', $user_id);

        return array_pluck($query->get()->first()->roles->toArray(), 'role_name');
    }

    public function getUsersThatHasPrivilege($privilege_name)
    {
        $query = DB::table('dm_user_role')
                        ->select('dm_user_role.user_id')
                        ->leftjoin('dm_role_privilege', 'dm_user_role.role_name', '=', 'dm_role_privilege.role_name')
                        ->where('dm_role_privilege.privilege_name', '=', $privilege_name)
                        ->orWhere('dm_user_role.role_name', '=', 'Administrator')
                        ->distinct();

        return $query->get();
    }

    public function getUserOwnPrivileges($user_id)
    {
        $query = DB::table('dm_user_role')
                        ->select('dm_role_privilege.privilege_name')
                        ->leftjoin('dm_role_privilege', 'dm_user_role.role_name', '=', 'dm_role_privilege.role_name')
                        ->where('dm_user_role.user_id', '=', $user_id)
                        ->whereExists(function ($query) {
                            $query->select(DB::raw(1))
                                  ->from('dm_role_privilege')
                                  ->whereRaw('dm_user_role.role_name = dm_role_privilege.role_name');
                        })->distinct();

        return array_pluck($query->get()->toArray(), 'privilege_name');
    }

    /**
     * Permission Check Via Query Builder
     *
     * @param [string] $action
     * @return boolval
     */
    public function isPermited($user_id, $action)
    {
        $query = DB::table('dm_user_role')
                        ->select('dm_user_role.role_name')
                        ->leftjoin('dm_role_privilege', 'dm_user_role.role_name', '=', 'dm_role_privilege.role_name')
                        ->where([
                            ['dm_user_role.user_id', '=', $user_id],
                            ['dm_role_privilege.privilege_name', '=', $action]
                        ]);

        return ( empty($query->get()->toArray()) ) ? false:true;
    }
}