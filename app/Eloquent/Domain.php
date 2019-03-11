<?php

namespace App\Eloquent;

use Illuminate\Database\Eloquent\Model;

class Domain extends Model
{
    protected $table = 'dm_domain';

    protected $connection = 'domain';

    protected $primaryKey = 'domain';
    protected $keyType = 'string';
    protected $dateFormat = 'Y/m/d';
    public $incrementing = false;

    protected $guarded = [];
    protected $hidden = [];

    /**
     *  網域的所有網域工作歷史紀錄，不限定申請單
     */
    public function histories()
    {
        return $this->hasMany('App\Eloquent\ApplicationAdminlog', 'domain', 'domain');
    }

    public function applications()
    {
        return $this->hasMany('App\Eloquent\Application', 'domain', 'domain');
    }

    public function sales()
    {
        return $this->belongTo('App\User', 'user_id', 'user_id');
    }

    public function lastApplication()
    {
        return $this->belongsTo('App\Eloquent\Application', 'application_id', 'application_id');
    }

    public function manageStatus()
    {
        return $this->belongsTo('App\Eloquent\ManageStatus', 'manage_status', 'id');
    }
}
