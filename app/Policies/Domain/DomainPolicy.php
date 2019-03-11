<?php

namespace App\Policies\Domain;

use App\User;
use App\Domain;
use App\Policies\GlobalPolicy;
use App\Services\Auth\PermissionService;
use Illuminate\Auth\Access\HandlesAuthorization;

class DomainPolicy extends GlobalPolicy
{
    use HandlesAuthorization;

    public function __construct(PermissionService $permSrv)
    {
        parent::__construct($permSrv);
    }

    public function abilityGet()
    {
        // 會於稍後傳入 Gate::resource 方法作為其第三參數
        return [
            'entry' => 'entry',
            'list' => 'list'
        ];
    }

    /**
     * Determine whether the user can enter the domain manage.
     *
     * @param  \App\User  $user
     * @param  \App\Domain  $domain
     * @return mixed
     */
    public function entry(User $user, Domain $domain)
    {
        return $this->permSrv->ifActionPermited('domain.'.__FUNCTION__);
    }

    /**
     * Determine whether the user can view the domain.
     *
     * @param  \App\User  $user
     * @param  \App\Domain  $domain
     * @return mixed
     */
    public function view(User $user, Domain $domain)
    {
        return true;
    }

    /**
     * Determine whether the user can create domains.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        $this->permSrv->recache();
        return $this->permSrv->ifActionPermited('domain.'.__FUNCTION__);
    }

    /**
     * Determine whether the user can update the domain.
     *
     * @param  \App\User  $user
     * @param  \App\Domain  $domain
     * @return mixed
     */
    public function update(User $user, Domain $domain)
    {
        return true;
    }

    /**
     * Determine whether the user can delete the domain.
     *
     * @param  \App\User  $user
     * @param  \App\Domain  $domain
     * @return mixed
     */
    public function delete(User $user, Domain $domain)
    {
        return true;
    }
}
