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
        Schema::create('eggs', function (Blueprint $table) {
            $table->id();
            $table->string('batch_code');                   // links to chicken_batches.batch_code
            $table->integer('total_eggs')->default(0);
            $table->integer('broken_eggs')->default(0);
            $table->integer('good_eggs')->default(0);
            $table->integer('sold_eggs')->default(0);
            $table->text('remarks')->nullable();
            $table->unsignedBigInteger('ORDER_ID')->nullable(); // link to orders if exists
            $table->timestamps();

            // Foreign key constraint for batch
            $table->foreign('batch_code')
                  ->references('batch_code')
                  ->on('chicken_batches')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('eggs');
    }
};
