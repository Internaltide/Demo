<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRoleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('migrations')->create('dm_role', function (Blueprint $table) {
            // Define Table Option
            $table->engine = 'InnoDB';
            $table->charset = 'utf8';
            $table->collation = 'utf8_general_ci';

            // Define Table Column
            $table->string('role_name', 30)->comment('角色唯一名稱');
            $table->unsignedTinyInteger('role_type')->default(0)->comment('角色類型');
            $table->string('label', 50)->comment('顯示名稱');
            $table->text('description')->nullable()->comment('角色描述');

            // Define Primary Key
            $table->primary('role_name');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('migrations')->dropIfExists('dm_role');
    }
}
