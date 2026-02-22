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
        Schema::table('orders', function (Blueprint $table) {
            $table->date('pickup_date')->nullable()->after('notes');
            $table->time('pickup_time')->nullable()->after('pickup_date');
            $table->string('pickup_location')->nullable()->after('pickup_time');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn(['pickup_date', 'pickup_time', 'pickup_location']);
        });
    }
};
