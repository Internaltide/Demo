<?php

namespace App\Http\Controllers\Domain;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\Auth\PolicyAssignService;

class DomainController extends Controller
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

    public function index()
    {
        echo 'Domain Manage<br/>';
        $this->authorize('domain.create');
    }
}
