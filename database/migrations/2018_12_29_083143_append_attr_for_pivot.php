<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AppendAttrForPivot extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Append Date Column For dm_user_role
        Schema::connection('migrations')->table('dm_user_role', function (Blueprint $table) {
            $table->dateTime('created_at');
            $table->dateTime('updated_at');

            $table->index('updated_at');
        });

        // Append Data Column For dm_role_privilege
        Schema::connection('migrations')->table('dm_role_privilege', function (Blueprint $table) {
            $table->dateTime('created_at');
            $table->dateTime('updated_at');

            $table->index('updated_at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // remove index for dm_user_role
        Schema::connection('migrations')->table('dm_user_role', function (Blueprint $table) {
            $table->dropIndex('dm_user_role_updated_at_index');

            $table->dropColumn(['created_at','updated_at']);
        });

        // remove index for dm_role_privilege
        Schema::connection('migrations')->table('dm_role_privilege', function (Blueprint $table) {
            $table->dropIndex('dm_role_privilege_updated_at_index');

            $table->dropColumn(['created_at','updated_at']);
        });
    }
}
