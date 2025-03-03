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
        Schema::create('jadwalpoliklinik', function (Blueprint $table) {
            $table->id();
            $table->string('kode')->unique();
            $table->foreignId('dokter_id')->constrained('dokter');
            $table->foreignId('poliklinik_id')->references('poliklinik_id')->on('dokter');
            $table->date('tanggal_praktek');
            $table->time('jam_mulai');
            $table->time('jam_selesai');
            $table->integer('jumlah');
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
        Schema::dropIfExists('jadwalpoliklinik');
    }    
};
