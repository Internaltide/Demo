<?php

namespace App\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use App\Services\Auth\PermissionService;

abstract class GlobalPolicy
{
    use HandlesAuthorization;

    public $domainAlias = null;
    protected $hidden = false; // if hide from checkbox elements ...etc
    protected $requireBase = true; // if append base abilities
    protected $permSrv;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct(PermissionService $permSrv)
    {
        $this->permSrv = $permSrv;
    }

    /**
     * Check if policy require base abilities
     *
     * @return boolean
     */
    public function ifRequireBaseAbilities()
    {
        return $this->requireBase;
    }

    public function ifHidePrivilegeItem()
    {
        return $this->hidden;
    }

    /**
     * To grant administrator full permission directly.
     *
     * @return void
     */
    public function before()
    {
        return ($this->permSrv->isAdmin()) ? true:null;
    }

    protected function simplePermCheck($method)
    {
        return $this->permSrv->ifActionPermited(
            $this->getPrivilegeNameByMethod($method)
        );
    }

    protected function getPrivilegeNameByMethod($method)
    {
        $abilities = $this->abilityGet();

        return $this->domainAlias . "." . array_search($method, $abilities);
    }

    /**
     * Function for define any policy method mapping
     *
     * @return void
     *
     */
    abstract function abilityGet();
}
