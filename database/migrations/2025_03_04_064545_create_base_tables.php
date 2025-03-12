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
        // Create user table
        Schema::create('user', function (Blueprint $table) {
            $table->id();
            $table->string('nama_user');
            $table->string('username')->unique();
            $table->string('password');
            $table->string('no_telepon');
            $table->string('foto_user')->nullable();
            $table->enum('roles', ['admin', 'petugas', 'pasien']);
            $table->rememberToken();
            $table->timestamps();
        });

        // Create poliklinik table
        Schema::create('poliklinik', function (Blueprint $table) {
            $table->id()->unique();
            $table->string('nama_poliklinik');
            $table->timestamps();
        });

        // Create dokter table
        Schema::create('dokter', function (Blueprint $table) {
            $table->id();
            $table->string('nama_dokter');
            $table->foreignId('poliklinik_id')->constrained('poliklinik')->onDelete('cascade');
            $table->string('foto_dokter')->nullable();
            $table->timestamps();
        });

        // Create datapasien table
        Schema::create('datapasien', function (Blueprint $table) {
            $table->id();
            $table->string('foto_pasien')->nullable();
            $table->string('nik')->nullable();
            $table->string('nama_pasien');
            $table->string('email');
            $table->string('no_telp');
            $table->string('tempat_lahir')->nullable();
            $table->date('tanggal_lahir')->nullable();
            $table->enum('jenis_kelamin', ['laki-laki', 'perempuan'])->nullable();
            $table->text('alamat')->nullable();
            $table->string('scan_ktp')->nullable();
            $table->string('no_kberobat')->unique()->nullable();
            $table->string('scan_kberobat')->nullable();
            $table->string('no_kbpjs')->nullable();
            $table->string('scan_kbpjs')->nullable();
            $table->string('scan_kasuransi')->nullable();
            $table->foreignId('user_id')->constrained('user');
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
        Schema::dropIfExists('datapasien');
        Schema::dropIfExists('dokter');
        Schema::dropIfExists('poliklinik');
        Schema::dropIfExists('user');
    }
};
