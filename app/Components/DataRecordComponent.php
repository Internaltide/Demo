<?php

namespace App\Components;

class DataRecordComponent
{
    public function roleRecord($index=null)
    {
        return view('themes.default.role.roleRecord', [
            'index' => $index
        ]);
    }
}