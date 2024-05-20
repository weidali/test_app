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
            $table->float('earn_passive_per_sec', 4)->default(0.1);
            $table->integer('last_passive_earn')->default(0);
            $table->integer('taps_recover_per_sec')->default(1);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('players', function (Blueprint $table) {
            $table->dropColumn([
                'earn_passive_per_sec',
                'last_passive_earn',
                'taps_recover_per_sec',
            ]);
        });
    }
};
