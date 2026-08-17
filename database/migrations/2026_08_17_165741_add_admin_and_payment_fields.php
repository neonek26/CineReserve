<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasColumn('users', 'is_admin')) {
            Schema::table('users', function (Blueprint $table) {
                $table->boolean('is_admin')->default(false);
            });
        }

        Schema::table('reservations', function (Blueprint $table) {
            $table->string('status')->default('pending');
            $table->decimal('total_price', 8, 2)->default(0.00);
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('is_admin');
        });

        Schema::table('reservations', function (Blueprint $table) {
            $table->dropColumn(['status', 'total_price']);
        });
    }
};