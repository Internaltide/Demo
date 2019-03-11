<?php

namespace App\Repositories\Application;

use App\Eloquent\ApplicationStatus;

class ApplicationStatusRepo
{

    private $model;

    public function __construct(Domain $status)
    {
        $this->model = $status;
    }
}