<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('players', function (Blueprint $table) {
            if (Schema::hasTable('players')) {
                Schema::table('players', function (Blueprint $table) {
                    if (Schema::hasColumn('players', 'max_taps')) {
                        $table->integer('max_taps')->default(200)->change();
                    }
                    if (Schema::hasColumn('players', 'available_taps')) {
                        $table->integer('available_taps')->default(200)->change();
                    }
                });
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('players', function (Blueprint $table) {
            if (Schema::hasTable('players')) {
                Schema::table('players', function (Blueprint $table) {
                    if (Schema::hasColumn('players', 'max_taps')) {
                        $table->integer('max_taps')->default(30)->change();
                    }
                    if (Schema::hasColumn('players', 'available_taps')) {
                        $table->integer('available_taps')->default(30)->change();
                    }
                });
            }
        });
    }
};
