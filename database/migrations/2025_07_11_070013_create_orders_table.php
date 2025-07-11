<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
   public function up()
{
    Schema::create('orders', function (Blueprint $table) {
        $table->id();
        $table->string('first_name');
        $table->string('last_name');
        $table->string('email');
        $table->string('phone_number');
        $table->text('description')->nullable();
        $table->decimal('amount', 10, 2);
        $table->string('currency')->default('TZS');
        $table->enum('delivery_option', ['delivered', 'pickup']);
        $table->enum('payment_method', ['cash', 'online']);
        $table->enum('status', ['unpaid', 'paid'])->default('unpaid');
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
