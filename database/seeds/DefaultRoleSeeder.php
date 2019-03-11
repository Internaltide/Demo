<?php

use Illuminate\Database\Seeder;

class DefaultRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::connection('domain')->table('dm_role')->insert([
            ['role_name' => 'Administrator', 'role_type'=> 2, 'label' => '超級管理員', 'description' => '將擁有完整的系統存取權']
            ['role_name' => 'Authorizer', 'role_type'=> 2, 'label' => '授權管理專員', 'description' => '能夠針對非屬於 Admin 及 Authorizer 兩種角色的人進行授權管理']
        ]);
    }
}
