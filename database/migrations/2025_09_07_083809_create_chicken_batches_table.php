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
        Schema::create('chicken_batches', function (Blueprint $table) {
            $table->id();
            $table->string('batch_code')->unique();   // for relation with entries & eggs
            $table->date('arrival_date');             // batch arrival date
            $table->integer('Quantity');              // number of chickens
            $table->string('batch_type');             // e.g., meat or eggs
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('chicken_batches');
    }
};
