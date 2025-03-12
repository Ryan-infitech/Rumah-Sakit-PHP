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
            $table->date('tanggal_praktek')->nullable();
            $table->string('hari')->nullable();
            $table->date('tanggal_mulai')->nullable();
            $table->date('tanggal_selesai')->nullable();
            $table->time('jam_mulai');
            $table->time('jam_selesai');
            $table->integer('jumlah');
            $table->enum('tipe_jadwal', ['harian', 'mingguan'])->default('harian');
            $table->boolean('is_active')->default(1);
            $table->json('hari_dalam_minggu')->nullable();
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
