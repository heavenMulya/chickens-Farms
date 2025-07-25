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
    $table->string('expense_type'); // feed, medicine, equipment, etc.
    $table->decimal('amount', 10, 2);
    $table->date('expense_date');
    $table->string('batch_code')->nullable();
    $table->text('remarks')->nullable();
    $table->timestamps();
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
