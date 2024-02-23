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
        Schema::create('debt_payments', function (Blueprint $table) {
            $table->id();
            $table->string('receipt_number');
            $table->dateTime('paid_date');
            $table->decimal('paid_amount');
            $table->decimal('balance');
            $table->string('debt_id');

            $table->timestamps();

            $table->foreign('debt_id')->references('id')->on('debts')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('debt_payments');
    }
};
