<?php

use Illuminate\Database\Migrations\Migration;
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
        // Get the current timestamp
        $now = now();
        
        // Default Laravel migration files to mark as already run
        $defaultMigrations = [
            '2014_10_12_000000_create_users_table',
            '2014_10_12_100000_create_password_resets_table',
            '2019_08_19_000000_create_failed_jobs_table',
            '2019_12_14_000001_create_personal_access_tokens_table'
        ];
        
        // Check if the migrations table exists
        if (Schema::hasTable('migrations')) {
            foreach ($defaultMigrations as $migration) {
                // Check if the migration has already been recorded
                $exists = DB::table('migrations')
                    ->where('migration', $migration)
                    ->exists();
                
                // If not, add it
                if (!$exists) {
                    DB::table('migrations')->insert([
                        'migration' => $migration,
                        'batch' => 1,
                    ]);
                }
            }
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Nothing to do here as we don't want to remove these entries
    }
};
