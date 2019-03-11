<?php

namespace App\Repositories\Application;

use App\Eloquent\ApplicationAdminlog;

class ApplicationAdminlogRepo
{

    private $model;

    public function __construct(ApplicationAdminlog $log)
    {
        $this->model = $log;
    }
}