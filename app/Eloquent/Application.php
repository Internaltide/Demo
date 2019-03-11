<?php

namespace App\Eloquent;

use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
    protected $table = 'dm_application';

    protected $connection = 'domain';

    protected $primaryKey = 'application_id';
    protected $keyType = 'integer';
    protected $dateFormat = 'Y/m/d H-i-s';
    public $incrementing = true;

    protected $guarded = [];
    protected $hidden = [
        'hosted_acc', 'hosted_password'
    ];

    /**
     *  當次申請單所屬的所有操作紀錄
     */
    public function logs()
    {
        return $this->hasMany('App\Eloquent\ApplicationAdminlog', 'application_id', 'application_id');
    }
}
