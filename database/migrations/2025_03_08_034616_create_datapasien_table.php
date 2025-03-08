<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDatapasienTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
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
            $table->string('no_kberobat')->unique()->nullable(); // Fixed typo from kberbat to kberobat
            $table->string('scan_kberobat')->nullable(); // Fixed typo from kberbat to kberobat
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
    }
}