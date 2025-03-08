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
       Schema::create('antrian', function (Blueprint $table) {
           $table->id();
           $table->integer('kode_jadwalpoliklinik');
           $table->bigInteger('kode_antrian')->nullable()->unique();
           $table->integer('no_antrian');
           $table->string('nama_pasien');
           $table->string('no_telp')->nullable();
           $table->foreignId('jadwalpoliklinik_id')->constrained('jadwalpoliklinik');
           $table->foreignId('id_pasien')->constrained('datapasien');
           $table->string('nama_dokter');
           $table->string('poliklinik');
           $table->string('penjamin');
           $table->string('no_bpjs')->nullable();
           $table->string('scan_kbpjs')->nullable();
           $table->string('scan_kasuransi')->nullable();
           $table->date('tanggal_berobat');
           $table->date('tanggal_reservasi');
           $table->string('scan_surat_rujukan')->nullable();
           $table->foreignId('user_id')->nullable()->constrained('user');
           $table->timestamps();
       });
    }
    
    /**
    * Reverse the migrations.
    *
    * @return void
    */
    public function down()
    {
       Schema::dropIfExists('antrian');
    }
};
