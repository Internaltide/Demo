<?php

namespace App\Console\Commands;

use App;
use Symfony\Component\Finder\Finder;
use App\Services\Auth\PolicyAssignService;
use App\Repositories\Authorization\PrivilegeRepo;
use Illuminate\Console\Command;

class BuildPrivilege extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'privilege:build
                                        {--L|list : Just list variant part(No database opreate)}
                                        {--F|force : Force delete invalid privilege and its relation data}
                                        {--locale=zh-tw : The locale used for translate the privilege label}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Build all privelege according the Gate ability define';

    /**
     * The policy assign service.
     *
     * @var policyAssign
     */
    private $policyAssign;

    private $privilegeRepo;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct( PolicyAssignService $policyAssign,
                                                  PrivilegeRepo $privilegeRepo )
    {
        parent::__construct();

        $this->policyAssign = $policyAssign;
        $this->privilegeRepo = $privilegeRepo;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        // Get privileges
        $newPrivileges = $this->getNecessaryPrivileges();

        // Get current privileges at database
        $currentPrivileges = $this->privilegeRepo-> privileges();

        // Deal with insert
        $this->insertPrivileges(
            array_diff($newPrivileges, $currentPrivileges)
        );

        // Deal with delete, if necessary
        if( $this->option('force') ){
            $this->deletePrivileges(
                array_diff($currentPrivileges, $newPrivileges)
            );
        }
    }

    /**
     * 依據 Policy 目錄內各 Policy 的定義，轉換出所有必須權限項
     *
     * @return array
     */
    private function getNecessaryPrivileges()
    {
        return $this->policyAssign->listAll();
    }

    private function insertPrivileges($privileges)
    {
        if( empty($privileges) ){
            $this->alert("No privilege need to insert");
            return false;
        }

        $insertdata = [];
        foreach( $privileges as $privilege ){
            $insertdata[] = [
                'privilege_name' => $privilege,
                'label' => $this->privilegeTranslate($privilege)
            ];
        }

        if( !$this->option('list') ){
            $this->privilegeRepo->batchInsert($insertdata);
        }

        $this->info("Insert New Privileges as Follow:");
        print_r($insertdata);
    }

    private function deletePrivileges($privileges)
    {
        if( empty($privileges) ){
            $this->alert("No privilege need to delete");
            return false;
        }

        if( !$this->option('list') ){
            $this->privilegeRepo->batchDelete($privileges);
        }

        $this->info("Delete Useless Privileges as Follow:");
        print_r($privileges);
    }

    private function privilegeTranslate($string)
    {
        $locale = $this->option('locale');
        App::setLocale(  $locale );

        $dictionary = 'privilege';
        $tmpArr = explode('.', $string);
        $seperator = ( in_array($locale, ['zh-tw']) ) ? '':' ';

        return $this->translate($dictionary, $tmpArr[0]).$seperator.$this->translate($dictionary, $tmpArr[1]);
    }

    private function translate($dictionary, $string)
    {
        $translated =  __("{$dictionary}.{$string}");

        return ( $translated === "{$dictionary}.{$string}" ) ? $string:$translated;
    }
}
