<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateApplicationAdminlogTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('migrations')->create('dm_application_admin_log', function (Blueprint $table) {
            // Define Table Option
            $table->engine = 'InnoDB';
            $table->charset = 'utf8';
            $table->collation = 'utf8_general_ci';

            // Define Table Column
            $table->unsignedInteger('log_id')->autoIncrement();
            $table->string('domain', 50);
            $table->unsignedInteger('application_id')->comment('申請單ID');
            $table->string('user_id', 30)->comment('執行者ID');
            $table->unsignedTinyInteger('log_type')->comment('紀錄類型');
            $table->string('content', 100)->comment('紀錄內容');
            $table->dateTime('created_at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('migrations')->dropIfExists('dm_application_admin_log');
    }
}
