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
        // First, check if the ratings table exists; if not, create it
        if (!Schema::hasTable('ratings')) {
            Schema::create('ratings', function (Blueprint $table) {
                $table->id();
                $table->foreignId('dokter_id')->constrained('dokter')->onDelete('cascade');
                $table->foreignId('user_id')->constrained('user')->onDelete('cascade');
                $table->decimal('rating', 3, 1); // Store ratings with one decimal place
                $table->text('review')->nullable();
                $table->timestamps();
            });
        }
        
        // Now add the antrian_id column if it doesn't exist
        if (Schema::hasTable('ratings') && !Schema::hasColumn('ratings', 'antrian_id')) {
            Schema::table('ratings', function (Blueprint $table) {
                $table->unsignedBigInteger('antrian_id')->nullable()->after('user_id');
                
                // Add foreign key constraint if antrian table exists
                if (Schema::hasTable('antrian')) {
                    $table->foreign('antrian_id')
                          ->references('id')
                          ->on('antrian')
                          ->onDelete('set null');
                }
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (Schema::hasTable('ratings') && Schema::hasColumn('ratings', 'antrian_id')) {
            Schema::table('ratings', function (Blueprint $table) {
                // Drop the foreign key constraint if it exists
                $foreignKeys = Schema::getConnection()
                    ->getDoctrineSchemaManager()
                    ->listTableForeignKeys('ratings');
                
                $foreignKeyNames = array_map(function($key) {
                    return $key->getName();
                }, $foreignKeys);
                
                if (in_array('ratings_antrian_id_foreign', $foreignKeyNames)) {
                    $table->dropForeign(['antrian_id']);
                }
                
                $table->dropColumn('antrian_id');
            });
        }
    }
};
