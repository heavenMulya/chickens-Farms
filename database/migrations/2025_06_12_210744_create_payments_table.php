<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->string('order_tracking_id')->unique();
            $table->string('merchant_reference')->nullable();
            $table->decimal('amount', 10, 2);
            $table->string('currency', 3);
            $table->text('description');
            $table->string('email');
            $table->string('first_name');
            $table->string('last_name');
            $table->string('phone_number');
            $table->string('status')->default('pending');
            $table->string('pesapal_tracking_id')->nullable();
            $table->string('payment_method')->nullable();
            $table->string('confirmation_code')->nullable();
            $table->text('payment_status_description')->nullable();
            $table->text('redirect_url')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('payments');
    }
};