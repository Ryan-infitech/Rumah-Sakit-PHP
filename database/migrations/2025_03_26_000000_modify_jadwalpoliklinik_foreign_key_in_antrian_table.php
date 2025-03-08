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
            // Drop the existing foreign key constraint
            $table->dropForeign(['jadwalpoliklinik_id']);
            
            // Add the foreign key constraint with CASCADE ON DELETE
            $table->foreign('jadwalpoliklinik_id')
                  ->references('id')
                  ->on('jadwalpoliklinik')
                  ->onDelete('cascade');
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
            // Drop the modified foreign key constraint
            $table->dropForeign(['jadwalpoliklinik_id']);
            
            // Re-add the original foreign key constraint without CASCADE
            $table->foreign('jadwalpoliklinik_id')
                  ->references('id')
                  ->on('jadwalpoliklinik');
        });
    }
};
