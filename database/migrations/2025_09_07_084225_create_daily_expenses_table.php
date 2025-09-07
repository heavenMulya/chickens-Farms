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
        Schema::create('daily_expenses', function (Blueprint $table) {
            $table->id();
            $table->string('expense_type');                  // e.g., feed, transport, etc.
            $table->decimal('amount', 12, 2);                // money value
            $table->date('date')->nullable();                // could be entry date
            $table->string('batch_code')->nullable();        // link with chicken_batches
            $table->text('remarks')->nullable();             // optional notes
            $table->date('expense_date');                    // actual expense date
            $table->timestamps();

            // if related to chicken_batches
            $table->foreign('batch_code')
                  ->references('batch_code')
                  ->on('chicken_batches')
                  ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('daily_expenses');
    }
};
