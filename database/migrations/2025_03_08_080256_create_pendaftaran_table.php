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
    }
    
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pendaftaran');
    }
};
