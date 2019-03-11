<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateApplicationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('migrations')->create('dm_application', function (Blueprint $table) {
            // Define Table Option
            $table->engine = 'InnoDB';
            $table->charset = 'utf8';
            $table->collation = 'utf8_general_ci';

            // Define Table Column
            $table->unsignedInteger('application_id')->autoIncrement()->comment('申請單單號');
            $table->string('domain', 50);
            $table->string('company_id', 30)->nullable();
            $table->string('user_id', 30);
            $table->unsignedTinyInteger('application_status')->default(1)->comment('申請單狀態');
            $table->unsignedTinyInteger('application_type')->comment('申請工作類型');
            $table->unsignedSmallInteger('application_charge')->nullable()->default(50)->comment('服務索取費用');
            $table->string('register_company', 100)->comment('註冊用的公司名稱');
            $table->string('register_address', 100)->comment('註冊用公司地址');
            $table->string('register_tel', 50)->comment('註冊用公司電話');
            $table->string('register_fax', 50)->comment('註冊用公司傳真');
            $table->string('register_vat', 50)->comment('註冊用公司統編');
            $table->string('register_contact', 100)->comment('註冊用聯絡人');
            $table->string('register_mail', 100)->comment('註冊用聯絡信箱');
            $table->string('registrar', 100)->nullable()->comment('非新申請的原網域註冊商');
            $table->unsignedTinyInteger('registration_term')->default(1)->comment('註冊總年份');
            $table->text('registration_epp')->nullable()->comment('網域轉移驗證碼');
            $table->string('hosted_acc', 50)->nullable()->comment('代管帳號');
            $table->string('hosted_pwd', 20)->nullable()->comment('代管密碼');
            $table->dateTime('created_at');
            $table->dateTime('updated_at');
            $table->text('note')->nullable()->comment('備忘');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('migrations')->dropIfExists('dm_application');
    }
}
