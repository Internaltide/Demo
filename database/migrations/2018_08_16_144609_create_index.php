<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIndex extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('migrations')->table('dm_domain', function (Blueprint $table) {
            $table->index('user_id');
            $table->index('manage_status');
            $table->index('updated_at');
        });

        Schema::connection('migrations')->table('dm_application_admin_log', function (Blueprint $table) {
            $table->index('domain');
            $table->index('created_at');
        });

        Schema::connection('migrations')->table('dm_application', function (Blueprint $table) {
            $table->index('domain');
            $table->index('user_id');
            $table->index('application_status');
            $table->index('application_type');
        });

        Schema::connection('migrations')->table('dm_user_role', function (Blueprint $table) {
            $table->foreign('role_name')
                ->references('role_name')->on('dm_role')
                ->onDelete('cascade')->onUpdate('cascade');
        });

        Schema::connection('migrations')->table('dm_role_privilege', function (Blueprint $table) {
            $table->foreign('role_name')
                ->references('role_name')->on('dm_role')
                ->onDelete('cascade')->onUpdate('cascade');

            $table->foreign('privilege_name')
                ->references('privilege_name')->on('dm_privilege')
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
        Schema::connection('migrations')->table('dm_role_privilege', function (Blueprint $table) {
            // remove foreign key
            $table->dropForeign(['privilege_name']);
            $table->dropForeign(['role_name']);
            // remove index
            $table->dropIndex('dm_role_privilege_privilege_name_foreign');
            $table->dropIndex('dm_role_privilege_role_name_foreign');
        });

        Schema::connection('migrations')->table('dm_user_role', function (Blueprint $table) {
            // remove foreign key
            $table->dropForeign(['role_name']);
            // remove index
            $table->dropIndex('dm_user_role_role_name_foreign');
        });

        Schema::connection('migrations')->table('dm_application', function (Blueprint $table) {
            $table->dropIndex(['application_type']);
            $table->dropIndex(['application_status']);
            $table->dropIndex(['user_id']);
            $table->dropIndex(['domain']);
        });

        Schema::connection('migrations')->table('dm_application_admin_log', function (Blueprint $table) {
            $table->dropIndex(['domain']);
            $table->dropIndex(['created_at']);
        });

        Schema::connection('migrations')->table('dm_domain', function (Blueprint $table) {
            $table->dropIndex(['user_id']);
            $table->dropIndex(['manage_status']);
            $table->dropIndex(['updated_at']);
        });
    }
}
