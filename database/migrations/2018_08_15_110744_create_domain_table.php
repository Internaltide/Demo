<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDomainTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('migrations')->create('dm_domain', function (Blueprint $table) {
            // Define Table Option
            $table->engine = 'InnoDB';
            $table->charset = 'utf8';
            $table->collation = 'utf8_general_ci';

            // Define Table Column
            $table->string('domain', 50);
            $table->string('company_id', 30);
            $table->string('user_id', 30)->comment('使用者ID(負責業務)');
            $table->unsignedInteger('application_id')->comment('指向最近一次結案申請單');
            $table->enum('status', ['S_ACTIVE', 'S_EXPIRED', 'S_INVALID'])->default('S_ACTIVE')->comment('WHOIS狀態');
            $table->unsignedTinyInteger('manage_status')->default(1)->comment('管理狀態');
            $table->date('expired_date');
            $table->string('registar', 100)->nullable()->comment('網域註冊商');
            $table->boolean('is_hosted')->default(false)->comment('是否由我方代管');
            $table->date('created_at')->comment('第一次列管建立日期');
            $table->date('updated_at');
            $table->text('note')->nullable()->comment('備忘');

            // Define Primary Key
            $table->primary('domain');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('migrations')->dropIfExists('dm_domain');
    }
}
