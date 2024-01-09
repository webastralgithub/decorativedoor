<?php

use App\Models\User;
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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->tinyInteger('user_id')->default(0);
            $table->string('order_date');
            $table->tinyInteger('order_status')->default('1');
            $table->integer('total_products');
            $table->integer('sub_total');
            $table->tinyInteger('sales_person')->default(0);
            $table->integer('vat');
            $table->integer('total');
            $table->string('invoice_no');
            $table->string('payment_type')->nullable();
            $table->tinyInteger('payment_status')->deafult('1');
            $table->integer('pay');
            $table->integer('due');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
