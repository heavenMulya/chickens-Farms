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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->decimal('Discount', 8, 2)->default(0); // discount amount
            $table->decimal('price', 12, 2);               // product price
            $table->string('status')->default('active');   // product status
            $table->text('Description')->nullable();
            $table->string('image')->nullable();           // image path or URL
            $table->string('batch_type')->nullable();      // meat or eggs
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
