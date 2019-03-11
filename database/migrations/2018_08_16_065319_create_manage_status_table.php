<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateManageStatusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('migrations')->create('dm_manage_status', function (Blueprint $table) {
            // Define Table Option
            $table->engine = 'InnoDB';
            $table->charset = 'utf8';
            $table->collation = 'utf8_general_ci';

            // Define Table Column
            $table->unsignedTinyInteger('id')->comment('狀態編號');
            $table->string('label', 15)->comment('狀態名稱');

            // Define Primary Key
            $table->primary('id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('migrations')->dropIfExists('dm_manage_status');
    }
}
