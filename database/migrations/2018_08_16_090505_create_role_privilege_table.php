<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRolePrivilegeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('migrations')->create('dm_role_privilege', function (Blueprint $table) {
            // Define Table Option
            $table->engine = 'InnoDB';
            $table->charset = 'utf8';
            $table->collation = 'utf8_general_ci';

            // Define Table Column
            $table->unsignedInteger('id')->autoIncrement();
            $table->string('role_name', 30);
            $table->string('privilege_name', 30);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('migrations')->dropIfExists('dm_role_privilege');
    }
}
