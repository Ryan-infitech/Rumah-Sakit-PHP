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
        Schema::create('user', function (Blueprint $table) {
            $table->id(); // Menambahkan kolom id (primary key)
            $table->string('nama_user'); // Menambahkan kolom nama_user
            $table->string('username')->unique(); // Menambahkan kolom username dengan constraint unique
            $table->string('password'); // Menambahkan kolom password
            $table->string('no_telepon'); // Menambahkan kolom no_telepon
            $table->string('foto_user')->nullable(); // Menambahkan kolom foto_user, nullable jika tidak diisi
            $table->enum('roles', ['admin', 'petugas', 'pasien']); // Menambahkan kolom roles dengan nilai enum
            $table->rememberToken(); // Added remember_token
            $table->timestamps(); // Menambahkan kolom created_at dan updated_at
        });
    }
    
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user');
    }
};
