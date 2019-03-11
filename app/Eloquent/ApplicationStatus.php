<?php

namespace App\Eloquent;

use Illuminate\Database\Eloquent\Model;

class ApplicationStatus extends Model
{
    protected $table = 'dm_application_status';

    protected $connection = 'domain';

    public $timestamps = false;

    protected $guarded = [];
    protected $hidden = [];

    public function includeApplications()
    {
        return $this->hasMany('App\Eloquent\Application', 'application_status', 'id');
    }
}
