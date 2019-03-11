<?php

namespace App\Repositories\Domain;

use App\Eloquent\Domain;

class DomainRepo
{

    private $model;

    public function __construct(Domain $domain)
    {
        $this->model = $domain;
    }
}