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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('email');
            $table->string('phone_number');
            $table->text('description')->nullable();
            $table->decimal('amount', 12, 2);         // amount with 2 decimal places
            $table->string('currency', 10)->default('TZS');
            $table->string('delivery_option')->nullable();
            $table->string('payment_method')->nullable();
            $table->string('status')->default('pending');
            $table->string('sales_status')->default('pending');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->text('cancel_reason')->nullable();
            $table->timestamps();

            // foreign key to users
            $table->foreign('user_id')
                  ->references('id')
                  ->on('users')
                  ->onDelete('set null');
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
