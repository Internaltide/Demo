<?php

namespace App\Traits;

trait ControllerTrait
{
    private function redirect($name, $para=[], $withMessage=[])
    {
        // flash data
        foreach($withMessage as $key=>$msg){
            session()->flash($key,$msg);
        }

        return redirect()->route($name,$para);
    }
}