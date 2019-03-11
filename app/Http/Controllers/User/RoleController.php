<?php

namespace App\Http\Controllers\User;

use Log;
use Gate;
use Auth;
use Mail;
use Component;
use App\IManageService;
use Illuminate\Http\Request;
use App\Mail\RoleRemoved;
use App\Http\Controllers\Controller;
use App\Exceptions\ActionException;
use App\Services\Auth\PolicyAssignService;
use App\Traits\SegmentTrait;
//use App\Traits\ControllerTrait;

class RoleController extends Controller
{

    //use ControllerTrait;
    use SegmentTrait;

    private $moduleAdministratorMail;
    private $manager;
    private $logger;
    private $notify;
    private $policyAssign;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct( IManageService $manage,
                                                  PolicyAssignService $policyAssign )
    {
        $policyAssign->assign(__CLASS__);

        $this->moduleAdministratorMail = env('APP_PERMMANAGE_MAIL', 'administrator@whatsoft.com');

        $this->manager = $manage;
        $this->logger = Log::stack(['activity', 'notify']);
        $this->notify = Log::channel('notify');
        $this->policyAssign = $policyAssign;
    }

    public function ajxform($key, $type)
    {
        switch($type){
            case 'assignUser':
                return Component::create('ModalBody@userCheckboxUnderRole', $key, route('perm.assignUsers'));
                break;
            case 'assignPrivilege':
                $exclude = $this->policyAssign->domainsOfInvisiable();
                return Component::create('ModalBody@privilegeCheckboxUnderRole', $key, $exclude, route('perm.assignPrivileges'));
                break;
            case 'updateRole':
                return Component::create('ModalBody@updateRoleForm', $key, route('perm.updateRole'));
                break;
            case 'createRoles':
                return Component::create('ModalBody@createRolesForm', route('perm.createRoles'));
                break;
            case 'updatePrivilege':
                return Component::create('ModalBody@updatePrivilegeForm', $key, route('perm.updatePrivilege'));
                break;
        }
    }

    public function ajxRecordElement(Request $request, $typename)
    {
        switch($typename){
            case 'roleRecord':
                return Component::create('DataRecord@roleRecord');
                break;
        }
    }

    public function landing()
    {
        if (Gate::denies('permission.entry')) {
            $this->notify->notice("你沒有權限管理模組的存取權限，系統已跳轉回儀表板首頁", ['title' => '模組存取拒絕']);
            return redirect()->route('dashboard');
        }

        $rolelist = $this->manager->getAllRoles();
        $privilegelist = $this->manager->getAllPrivileges();

        return view('themes.default.role.dashboard',[
            'function' => ucfirst( $this->getSubModule() ),
            'description' => __('role.module_desc'),
            'rolelist' => $rolelist,
            'privilegelist' => $privilegelist,
            'form' => (object)[
                'roletype' => 'roletype',
                'rolekey' => 'rolekey'
            ]
        ]);
    }

    public function createRoles(Request $request)
    {
        if (Gate::denies('permission.createRole')) {
            $this->notify->notice("您沒有創建新角色的權限", ['title' => '操作存取拒絕']);
            return redirect()->route('user.perm');
        }

        $formated = $this->formated(__FUNCTION__,
            json_decode( $request->input('savedata') )
        );

        try {
            $result = $this->manager->createRoles(
                $formated
            );
            $this->logger->info("您已經成功定義了新的角色", [
                'title' => '角色創建成功',
                'username' => Auth::user()->user_name
            ]);
        } catch (ActionException $th) {
            report($th);
        }

        return redirect()->route('user.perm');
    }

    public function assignUsers(Request $request)
    {
        if (Gate::denies('permission.assignUser', $request->input('role'))) {
            $this->notify->notice("您沒有指派新使用者的權限", ['title' => '操作存取拒絕']);
            return redirect()->route('user.perm');
        }

        try {
            $this->manager->updateRoleUsersPivot(
                $request->input('role'),
                $request->input('users')
            );
            $this->logger->info("您已經成功定義了角色 ".$request->input('role')." 的使用者", [
                'title' => '使用者指派成功',
                'username' => Auth::user()->user_name
            ]);
        } catch (ActionException $th) {
            report($th);
        }

        return redirect()->route('user.perm');
    }

    public function assignPrivileges(Request $request)
    {
        if (Gate::denies('permission.assignPrivi', $request->input('role'))) {
            $this->notify->notice("您沒有指派新授權的權限", ['title' => '操作存取拒絕']);
            return redirect()->route('user.perm');
        }

        try {
            $this->manager->updateRolePrivilegesPivot(
                $request->input('role'),
                $request->input('privileges')
            );
            $this->logger->info("您已經成功定義了角色 ".$request->input('role')." 的授權項目", [
                'title' => '角色授權成功',
                'username' => Auth::user()->user_name
            ]);
        } catch (ActionException $th) {
            report($th);
        }

        return redirect()->route('user.perm');
    }

    public function updateRole(Request $request)
    {
        if (Gate::denies('permission.updateRole', $request->input('role'))) {
            $this->notify->notice("您沒有執行角色資訊更新的權限", ['title' => '操作存取拒絕']);
            return redirect()->route('user.perm');
        }

        try {
            $this->manager->updateRoleInfo(
                $request->input('role'),
                [
                    'name' => $request->input('name'),
                    'description' => $request->input('description')
                ]
            );
            $this->logger->info("您已經變更了角色 ".$request->input('role')." 的資訊", [
                'title' => '角色資訊更新成功',
                'username' => Auth::user()->user_name
            ]);
        } catch (ActionException $th) {
            report($th);
        }

        return redirect()->route('user.perm');
    }

    public function deleteRole(Request $request)
    {
        if (Gate::denies('permission.deleteRole', $request->input('rolekey'))) {
            $this->notify->notice("您沒有刪除角色的權限", ['title' => '操作存取拒絕']);
            return redirect()->route('user.perm');
        }

        try {
            $this->manager->deleteRoles(
                $request->input('rolekey')
            );

            Mail::to($this->moduleAdministratorMail)->queue(new RoleRemoved());

            $this->logger->info("您已經成功刪除了指定角色及其關聯資料", [
                'title' => '角色刪除成功',
                'delRole' => $request->input('rolekey'),
                'username' => Auth::user()->user_name
            ]);
        } catch (ActionException $th) {
            report($th);
        }

        return redirect()->route('user.perm');
    }

    /*public function deleteRoles(Request $request, $dataset)
    {
        foreach( $dataset as $type=>$name ){
            $this->binding($type);
            $this->manager->deleteRoles($name);
        }
    }*/

    public function updatePrivilege(Request $request)
    {
        if (Gate::denies('permission.updatePrivi')) {
            $this->notify->notice("您沒有執行授權資訊更新的權限", ['title' => '操作存取拒絕']);
            return redirect()->route('user.perm');
        }

        try {
            $this->manager->updatePrivilegeInfo(
                $request->input('privilege'),
                [
                    'description' => $request->input('description')
                ]
            );
            $this->logger->info("您已經變更了指定權限項 ".$request->input('privilege')." 的資訊", [
                'title' => '權限項資訊更新成功',
                'username' => Auth::user()->user_name
            ]);
        } catch (ActionException $th) {
            report($th);
        }

        return redirect()->route('user.perm');
    }

    private function formated($srcMethod, $dataset)
    {
        switch($srcMethod){
            case 'createRoles':
                return $this->formatRolesCreate($dataset);
                break;
        }
    }

    private function formatRolesCreate($dataset)
    {
        $tmp = [];
        $formated = [];
        foreach( $dataset as $data ){
            $tmp['role_name'] = $data->key;
            $tmp['label'] = $data->name;
            $tmp['description'] = $data->desc;
            $tmp['role_type'] = ROLE_GENERAL;
            $formated[] = $tmp;
        }

        return $formated;
    }
}
