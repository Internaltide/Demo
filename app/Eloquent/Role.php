<?php

namespace App\Eloquent;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $table = 'dm_role';

    protected $connection = 'domain';

    protected $primaryKey = 'role_name';
    protected $keyType = 'string';
    public $timestamps = false;
    public $incrementing = false;

    protected $guarded = [];
    protected $hidden = [];

    /**
     * Get the label of role type.
     *
     * @param  string  $value
     * @return string
     */
    public function getRoleTypeLabelAttribute()
    {
        $typeLabel = [
            0 => 'General',
            1 => 'Service',
            2 => 'System'
        ];

        return $typeLabel[$this->role_type];
    }

    /**
     * get all users that be specified certain role
     *
     * @return object
     */
    public function users()
    {
        return $this->belongsToMany('App\User','dm_user_role','role_name','user_id','role_name','user_id')
                          ->withPivot('created_at', 'updated_at')->withTimestamps();
    }

    /**
     * get all privileges owned by certain role
     *
     * @return object
     */
    public function privileges()
    {
        return $this->belongsToMany('App\Eloquent\Privilege','dm_role_privilege','role_name','privilege_name')
                          ->withPivot('created_at', 'updated_at')->withTimestamps();
    }
}
