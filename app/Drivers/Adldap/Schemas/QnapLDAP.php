<?php

namespace App\Drivers\Adldap\Schemas;

use Adldap\Schemas\OpenLDAP;

class QnapLDAP extends OpenLDAP
{
    // Override objectGuid Attr Name
    public function objectGuid()
    {
        return 'uidnumber';
    }

    public function objectGuidRequiresConversion()
    {
        return false;
    }
}