<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class FixDatabaseTablesCommand extends Command
{
    protected $signature = 'db:fix-tables';
    protected $description = 'Fix database tables if they are not set up correctly';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $this->info('Checking database tables...');

        // Check if user table exists
        if (!Schema::hasTable('user')) {
            $this->warn('User table does not exist. Creating it...');
            
            Schema::create('user', function ($table) {
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
            
            $this->info('User table created successfully.');
        } else {
            $this->info('User table exists.');
        }

        $this->info('Database check completed.');
        
        return 0;
    }
}
