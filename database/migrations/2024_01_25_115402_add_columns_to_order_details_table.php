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
        Schema::table('order_details', function (Blueprint $table) {
         $table->unsignedBigInteger('jamb_id')->nullable();
         $table->unsignedBigInteger('typeofdoor_id')->nullable();
         $table->unsignedBigInteger('locationofdoor_id')->nullable();
         $table->unsignedBigInteger('left_id')->nullable();
         $table->unsignedBigInteger('right_id')->nullable();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('order_details', function (Blueprint $table) {
        $table->dropColumn('jamb_id');
        $table->dropColumn('typeofdoor_id');
        $table->dropColumn('locationofdoor_id');
        $table->dropColumn('left_id');
        $table->dropColumn('right_id');

        });
    }
};
