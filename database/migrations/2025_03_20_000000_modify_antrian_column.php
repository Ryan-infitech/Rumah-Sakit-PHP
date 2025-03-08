<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Modify the kode_jadwalpoliklinik column to allow string values instead of just integers
        DB::statement('ALTER TABLE antrian MODIFY COLUMN kode_jadwalpoliklinik VARCHAR(50) NOT NULL');
        
        // Convert any existing integer values to string format
        DB::statement('UPDATE antrian SET kode_jadwalpoliklinik = CONCAT("JP", kode_jadwalpoliklinik) WHERE kode_jadwalpoliklinik != "" AND kode_jadwalpoliklinik NOT LIKE "JP%"');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // This is risky - data might be lost if there are non-numeric values
        // Only attempt to revert columns with numeric values
        DB::statement('UPDATE antrian SET kode_jadwalpoliklinik = REPLACE(kode_jadwalpoliklinik, "JP", "") WHERE kode_jadwalpoliklinik LIKE "JP%"');
        DB::statement('ALTER TABLE antrian MODIFY COLUMN kode_jadwalpoliklinik INTEGER NOT NULL');
    }
};
