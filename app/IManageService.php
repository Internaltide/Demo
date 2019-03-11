<?php

namespace App;

use App\Mediator;
use App\Traits\EntityFetchTrait;

abstract class IManageService
{
    use EntityFetchTrait;

    protected $mediator;

    public function __construct()
    {
        $this->mediator = Mediator::instance();
    }

    public function ifCurrentLoginIsAdmin()
    {
        return $this->mediator->ifCurrentLoginIsAdmin();
    }
}