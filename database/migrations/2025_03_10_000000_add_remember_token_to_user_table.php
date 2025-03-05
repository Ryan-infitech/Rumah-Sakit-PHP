<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('user') && !Schema::hasColumn('user', 'remember_token')) {
            Schema::table('user', function (Blueprint $table) {
                $table->rememberToken();
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (Schema::hasTable('user') && Schema::hasColumn('user', 'remember_token')) {
            Schema::table('user', function (Blueprint $table) {
                $table->dropRememberToken();
            });
        }
    }
};
