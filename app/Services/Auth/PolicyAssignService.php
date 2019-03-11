<?php

namespace App\Services\Auth;

use App;
use Gate;
use Illuminate\Http\Request;

use Storage;
use Symfony\Component\Finder\Finder;


class PolicyAssignService
{
    private $policy;

    /**
     * The name of method to get policies definition
     *
     * @method string
     */
    private $method = 'abilityGet';

    /**
     * Ploicy Class Path Segments
     *
     * @domain: 領域名稱
     */
    private $rootPath = 'App\\Policies\\';
    private $subPath = '';
    private $domain = '';
    private $suffix = 'Policy';

    public function __construct()
    {
        // do nothing
    }

    public function definition_method()
    {
        return $this->method;
    }

    public function policy_suffix()
    {
        return $this->suffix;
    }

    /**
     * Return policy path
     *
     * @return string
     */
    public function policy_path()
    {
        // 遵循 Laravel Path Helper Function 的格式慣例
        return str_replace(
            ['\\', 'App'],
            ['/', 'app'],
            base_path().DIRECTORY_SEPARATOR.$this->rootPath
        );
    }

    /**
     * Usually useful when you want hide permission items of invisiable domain
     *
     * @return array
     */
    public function domainsOfInvisiable()
    {
        return $this->runVistor(function($policy){
            $this->resolve($policy, 'Policy');
            if( $this->policy->ifHidePrivilegeItem() ){
                return $this->finalDomain();
            }
        });
    }

    /**
     * Define policy mapping via Gate
     *
     * @param [string] $controller
     * @return void
     */
    public function assign($controller)
    {
        // Reslove Policy PathName
        $policyName = $this->reslovePolicyFromController($controller);

        // Get corresponding policy object and defined all policy mapping
        if( class_exists($policyName) ) $this->gateDefine();
    }

    /**
     * Get All policy abilities define
     *
     * @return array
     */
    public function listAll()
    {
        return $this->runVistor(function($policy){
            $this->resolve($policy, 'Policy');

            $privileges = [];
            $abilities = $this->getAbilities();
            $prefix = strtolower( $this->finalDomain() );
            foreach($abilities as $ability=>$method){
                $privileges[] = "{$prefix}.{$ability}";
            }

            return $privileges;
        });
    }

    /**
     * Get policy abilities define
     *
     * @param [string] $policyName
     * @return array
     */
    public function list($policyName)
    {
        $this->resolve($policyName, 'Policy');

        return $this->getAbilities();
    }

    /**
     * Get policy use domain name
     *
     * @param [string] $policy
     * @return string
     */
    public function domainOf($policyName)
    {
        $this->resolve($policyName, 'Policy');

        return $this->finalDomain();
    }

    /**
     * For get the final use domain name.
     * The domain alias will be used when it existed; otherwise, we will use the resolved name from policy or controller.
     *
     * @return string
     */
    private function finalDomain()
    {
        return ( is_null($this->policy->domainAlias) ) ? $this->domain:$this->policy->domainAlias;
    }

    /**
     * Fetch all defined abilities from method $this->method and append base abilities
     *
     * @param [type] $policyName
     * @return void
     */
    private function getAbilities()
    {
        $abilities = ( method_exists($this->policy, $this->method) ) ? call_user_func(array($this->policy, $this->method)):[];

        return ($this->policy->ifRequireBaseAbilities()) ? $this->appendBaseAbilities($abilities):$abilities;
    }

    /**
     * Resolve the domain name from certain class name
     *
     * @param string $class
     * @param string $type
     * @return string
     */
    private function resolveDomain($class, $type=null)
    {
        $nameSuffix = (is_null($type)) ? $this->suffix:$type;

        while( str_contains($class, '\\') ){
            $class = str_after($class, '\\');
        }

        return substr($class, 0, strlen($class)-strlen($nameSuffix));
    }

    private function gateDefine()
    {
        $abilities = $this->getAbilities();

        if( is_array($abilities) ){
            $domain = $this->finalDomain();
            $policyName = $this->rootPath.$this->subPath.$this->domain.$this->suffix;
            Gate::resource(strtolower($domain), $policyName, $abilities);
        }
    }

    private function appendBaseAbilities($abilities)
    {
        $base = [
            'view' => 'view',
            'create' => 'create',
            'update' => 'update',
            'delete' => 'delete'
        ];

        foreach( $base as $ability=>$method ){
            if( !isset($abilities[$ability]) ) $abilities[$ability] = $base[$ability];
        }

        return $abilities;
    }

    private function reslovePolicyFromController($controller)
    {
        $this->resolve($controller, 'Controller');
        return $this->rootPath.$this->subPath.$this->domain.$this->suffix;
    }

    private function resolve($class, $suffix)
    {
        // create class path array
        $classPath = explode('\\',$class);

        // popup class name and fetch its domain name
        $this->domain = $this->resolveDomain(
            array_pop($classPath),
            $suffix
        );

        // reslove class path
        $this->subPath = '';
        $pluralName = $this->plural($suffix);
        while( $segment=array_pop($classPath) ){
            if($segment === $pluralName) break;
            $this->subPath = "$segment\\{$this->subPath}";
        }

        // Create policy object
        //echo "Resove " . $this->rootPath.$this->subPath.$this->domain.$this->suffix . " From {$class}";
        $this->policy = App::make($this->rootPath.$this->subPath.$this->domain.$this->suffix);
    }

    private function plural($singular)
    {
        $tmpstr = strtolower($singular);
        $endWithLetterY = '/[a-z]+[y]{1}$/';
        $endWithLetterF = '/[a-z]+[f]{1}$/';

        if( preg_match($endWithLetterY, $tmpstr) ){
            return substr($singular, 0, strlen($tmpstr)-1) . "ies";
        } else if( preg_match($endWithLetterF, $tmpstr) ){
            return substr($singular, 0, strlen($tmpstr)-1) . "ves";
        } else if( preg_match('/[a-z]+(s|x|ch|sh)$/', $tmpstr) ){
            return $singular . "es";
        } else {
            return $singular . "s";
        }
    }

    private function runVistor($vistorCallback)
    {
        $return = [];
        $namespace = App::getNamespace();
        $paths = array_wrap(  $this->policy_path() );
        foreach ((new Finder)->in($paths)->files() as $policy){
            $policy = $namespace.str_replace(
                ['/', '.php'],
                ['\\', ''],
                str_after($policy, app_path().DIRECTORY_SEPARATOR)
            );

            if( is_subclass_of($policy, App\Policies\GlobalPolicy::class) ){
                $result = $vistorCallback($policy);
                if(isset($result)) $return[] = $result;
            }
            unset($result);
        }

        return array_flatten($return);
    }
}
