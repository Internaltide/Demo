<?php

namespace App\Eloquent;

use Illuminate\Database\Eloquent\Model;

class ApplicationAdminlog extends Model
{
    protected $table = 'dm_application_admin_log';

    protected $connection = 'domain';

    protected $primaryKey = 'log_id';
    protected $keyType = 'integer';
    protected $dateFormat = 'Y/m/d H-i-s';
    public $incrementing = true;

    protected $guarded = [];
    protected $hidden = [];

    public function domain(){
        return $this->belongsTo('App\Eloquent\Domain', 'domain', 'domain');
    }

    public function application()
    {
        return $this->belongsTo('App\Eloquent\Application', 'application_id', 'application_id');
    }

    public function excutor()
    {
        return $this->belongsTo('App\User', 'user_id', 'user_id');
    }
}
