<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserTabel extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('migrations')->create('dm_users', function (Blueprint $table) {
            // Define Table Option
            $table->engine = 'InnoDB';
            $table->charset = 'utf8';
            $table->collation = 'utf8_general_ci';

            // Define Primary Key
            $table->unsignedInteger('id')->autoIncrement();

            // Define Table Column
            $table->string('user_id', 30)->comment('LDAP Identifier');
            $table->string('user_name', 100)->comment('LDAP Displayname');
            $table->string('login',100)->comment('LDAP Accountname');
            $table->string('password', 255)->comment('LDAP Password');
            $table->string('user_domain',50)->comment('DOMAIN');
            $table->string('email', 255)->comment('LDAP Mail');
            $table->unsignedTinyInteger('active')->default(1)->comment('啟用與否');
            $table->rememberToken();

            // Create Index
            $table->unique('user_id');
            $table->index('email');
        });

        Schema::connection('migrations')->table('dm_user_role', function (Blueprint $table) {
            $table->foreign('user_id')
                ->references('user_id')->on('dm_users')
                ->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('migrations')->table('dm_user_role', function (Blueprint $table) {
            // remove foreign key
            $table->dropForeign(['user_id']);

            // remove index
            $table->dropIndex('dm_user_role_user_id_foreign');
        });

        // drop table
        Schema::connection('migrations')->dropIfExists('dm_users');
    }
}
