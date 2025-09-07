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
        Schema::create('chicken_stocks', function (Blueprint $table) {
            $table->id();
            $table->string('batch_code');                 // links to chicken_batches.batch_code
            $table->integer('starting_total')->default(0);
            $table->integer('dead')->default(0);
            $table->integer('slaughtered')->default(0);
            $table->integer('sold')->default(0);
            $table->timestamps();

            // foreign key constraint for consistency
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
        Schema::dropIfExists('chicken_stocks');
    }
};
