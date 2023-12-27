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
            $table->unsignedBigInteger('sales_user_id');
            $table->unsignedBigInteger('coordinator_user_id');
            $table->unsignedBigInteger('assembler_user_id');
            $table->unsignedBigInteger('delivery_user_id');
            $table->unsignedBigInteger('accounted_user_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            //
        });
    }
};
