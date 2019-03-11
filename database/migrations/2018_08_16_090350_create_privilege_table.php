<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePrivilegeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('migrations')->create('dm_privilege', function (Blueprint $table) {
            // Define Table Option
            $table->engine = 'InnoDB';
            $table->charset = 'utf8';
            $table->collation = 'utf8_general_ci';

            // Define Table Column
            $table->string('privilege_name', 30)->comment('權限項唯一名稱');
            $table->string('label', 50)->comment('顯示名稱');
            $table->text('description')->nullable()->comment('權限項描述');

            // Define Primary Key
            $table->primary('privilege_name');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('migrations')->dropIfExists('dm_privilege');
    }
}
