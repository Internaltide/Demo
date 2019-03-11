<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\Auth\PolicyAssignService;

class PrivilegeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct( PolicyAssignService $policyAssign )
    {
        $policyAssign->assign(__CLASS__);
    }
}
