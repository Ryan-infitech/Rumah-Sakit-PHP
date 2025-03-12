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
        // Create pendaftaran table
        Schema::create('pendaftaran', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_pasien')->nullable();
            $table->unsignedBigInteger('jadwalpoliklinik_id');
            $table->string('nama_pasien')->nullable();
            $table->enum('penjamin', ['UMUM', 'BPJS', 'Asuransi']);
            $table->string('scan_surat_rujukan')->nullable();
            $table->foreign('id_pasien')->references('id')->on('datapasien')->onDelete('cascade');
            $table->foreign('jadwalpoliklinik_id')->references('id')->on('jadwalpoliklinik')->onDelete('cascade');
            $table->timestamps();
        });

        // Create antrian table
        Schema::create('antrian', function (Blueprint $table) {
            $table->id();
            $table->string('kode_jadwalpoliklinik', 50);
            $table->bigInteger('kode_antrian')->nullable()->unique();
            $table->integer('no_antrian');
            $table->string('nama_pasien');
            $table->string('no_telp')->nullable();
            $table->foreignId('jadwalpoliklinik_id')->constrained('jadwalpoliklinik')->onDelete('cascade');
            $table->foreignId('id_pasien')->constrained('datapasien');
            $table->string('nama_dokter');
            $table->unsignedBigInteger('dokter_id')->nullable();
            $table->string('poliklinik');
            $table->string('penjamin');
            $table->string('no_bpjs')->nullable();
            $table->string('scan_kbpjs')->nullable();
            $table->string('scan_kasuransi')->nullable();
            $table->date('tanggal_berobat');
            $table->enum('status', ['menunggu', 'diproses', 'dilayani'])->default('menunggu');
            $table->timestamp('waktu_selesai')->nullable();
            $table->timestamp('waktu_mulai')->nullable();
            $table->date('tanggal_reservasi');
            $table->string('scan_surat_rujukan')->nullable();
            $table->foreignId('user_id')->nullable()->constrained('user');
            $table->timestamps();
        });
        
        // Convert any existing values to string format for kode_jadwalpoliklinik
        DB::statement('UPDATE antrian SET kode_jadwalpoliklinik = CONCAT("JP", kode_jadwalpoliklinik) WHERE kode_jadwalpoliklinik != "" AND kode_jadwalpoliklinik NOT LIKE "JP%"');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('antrian');
        Schema::dropIfExists('pendaftaran');
    }
};
