<?php

namespace App\Repositories\Application;

use App\Eloquent\Application;

class ApplicationRepo
{

    private $model;

    public function __construct(Domain $application)
    {
        $this->model = $application;
    }
}