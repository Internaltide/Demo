<?php
/**
 * TODO: 引入Regex套件，統一Regex的寫法
 */

namespace App\Traits;

//use Adldap;

trait LdapAttrParserTrait
{
     /**
     * Convert Distinguished Name to an Domain string
     *
     * @return string
     */
    public function fetchDomainFromDN($dn)
    {
        if( empty($dn) ) return '';

        $sepratedomain = array();
        $sepratedn = explode(',',$dn);
        foreach ($sepratedn as $key => $compoent) {
            if( preg_match('/^(dc=){1}[a-zA-Z0-9\-]+/', $compoent) ){
                $sepratedomain[] = explode('=', $compoent)[1];
            }
        }

        return strtolower( implode('.', $sepratedomain) );
    }
}