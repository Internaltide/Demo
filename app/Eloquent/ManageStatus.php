<?php

namespace App\Eloquent;

use Illuminate\Database\Eloquent\Model;

class ManageStatus extends Model
{
    protected $table = 'dm_manage_status';

    protected $connection = 'domain';

    protected $primaryKey = 'id';
    protected $keyType = 'integer';
    public $timestamps = false;
    public $incrementing = false;

    protected $guarded = [];
    protected $hidden = [];

    public function includeDomains()
    {
        return $this->hasMany('App\Eloquent\Domain', 'manage_status', 'id');
    }
}
