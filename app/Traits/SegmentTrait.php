<?php

namespace App\Traits;

use URL;
use Request;

/**
 * URL Format: http://~/admin/{module}/{subModule}/{action}/~
 */
trait SegmentTrait
{
    public function getModule()
    {
        return Request::segment(2);
    }

    public function getSubModule()
    {
        return Request::segment(3);
    }

    public function getAction()
    {
        return Request::segment(4);
    }

    public function getModuleUrl()
    {
        return URL::to('/')
              .'/'.Request::segment(1)
              .'/'.Request::segment(2)
              .'/'.Request::segment(3);
    }

    public function getActionUrl()
    {
        return URL::to('/')
              .'/'.Request::segment(1)
              .'/'.Request::segment(2)
              .'/'.Request::segment(3)
              .'/'.Request::segment(4);
    }
}
