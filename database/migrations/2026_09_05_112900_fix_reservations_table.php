<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('reservations', function (Blueprint $table) {
            if (Schema::hasColumn('reservations', 'row_number')) {
                $table->dropColumn('row_number');
            }
            if (Schema::hasColumn('reservations', 'seat_number')) {
                $table->dropColumn('seat_number');
            }
        });
    }

    public function down(): void
    {
        Schema::table('reservations', function (Blueprint $table) {
            $table->integer('row_number')->nullable();
            $table->integer('seat_number')->nullable();
        });
    }
};