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
        Schema::create('chicken_entries', function (Blueprint $table) {
            $table->id();
            $table->string('batch_code');                     // links to chicken_batches.batch_code
            $table->date('entry_date');                       // entry date
            $table->integer('sold')->default(0);              // sold chickens
            $table->integer('dead')->default(0);              // dead chickens
            $table->integer('slaughtered')->default(0);       // slaughtered chickens
            $table->text('remarks')->nullable();              // optional notes
            $table->unsignedBigInteger('ORDER_ID')->nullable(); // if related to orders table
            $table->timestamps();

            // foreign key constraint (if you want relational integrity)
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
        Schema::dropIfExists('chicken_entries');
    }
};
