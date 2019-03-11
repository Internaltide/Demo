<?php

namespace App\Repositories\Domain;

use App\Eloquent\ManageStatus;

class ManageStatusRepo
{

    private $model;

    public function __construct(ManageStatus $status)
    {
        $this->model = $status;
    }
}