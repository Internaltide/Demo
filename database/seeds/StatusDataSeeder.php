<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StatusDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::connection('domain')->table('dm_manage_status')->insert([
            ['id' => 1, 'label' => '作業中'],
            ['id' => 2, 'label' => '列管中'],
            ['id' => 3, 'label' => '已鎖定'],
            ['id' => 4, 'label' => '歸檔已終止'],
            ['id' => 5, 'label' => '歸檔無回應'],
            ['id' => 6, 'label' => '歸檔已放棄'],
            ['id' => 7, 'label' => '歸檔已轉出'],
        ]);

        DB::connection('domain')->table('dm_application_status')->insert([
            ['id' => 1, 'label' => '候理中'],
            ['id' => 2, 'label' => '處理中'],
            ['id' => 3, 'label' => '已退回'],
            ['id' => 4, 'label' => '已結案'],
        ]);
    }
}
