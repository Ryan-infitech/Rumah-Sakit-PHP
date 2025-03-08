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
            $table->unsignedBigInteger('dokter_id')->nullable()->after('nama_dokter');
            // Add foreign key constraint if needed
            // $table->foreign('dokter_id')->references('id')->on('dokter')->onDelete('set null');
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
            // Remove foreign key constraint if added
            // $table->dropForeign(['dokter_id']);
            $table->dropColumn('dokter_id');
        });
    }
};
