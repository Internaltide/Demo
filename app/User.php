<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Traits\LdapAttrParserTrait;

class User extends Authenticatable
{
    use Notifiable, LdapAttrParserTrait;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'dm_users';

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * The connection name for the model.
     *
     * @var string
     */
    protected $connection = 'domain';

    /**
     * The attributes that are not mass assignable.
     *
     * @var array
     */
    protected $guarded = [
        'active','remember_token',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];


    /**
     * Set the user's domain.
     *
     * @param  string  $value
     * @return void
     */
    public function setUserDomainAttribute($dn)
    {
        $domain = $this->fetchDomainFromDN($dn);

        $this->attributes['user_domain'] = ( empty($domain) ) ? null:$domain;
    }

    /**
     * get user's specify roles
     *
     * @return object
     */
    public function roles()
    {
        return $this->belongsToMany('App\Eloquent\Role', 'dm_user_role',
                                                         'user_id', 'role_name', 'user_id', 'role_name');
    }
}
