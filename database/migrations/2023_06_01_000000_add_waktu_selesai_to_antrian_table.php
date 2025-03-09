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
        Schema::table('antrian', function (Blueprint $table) {
            if (!Schema::hasColumn('antrian', 'waktu_selesai')) {
                $table->timestamp('waktu_selesai')->nullable()->after('status');
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('antrian', function (Blueprint $table) {
            if (Schema::hasColumn('antrian', 'waktu_selesai')) {
                $table->dropColumn('waktu_selesai');
            }
        });
    }
};
