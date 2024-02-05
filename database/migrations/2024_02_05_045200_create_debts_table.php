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
        Schema::create('debts', function (Blueprint $table) {
            $table->id();
            // $table->dateTime('invoice_date');
            // $table->string('invoice_number');
            // $table->string('vendor_name');
            // $table->string('due_date');

            $table->string('debt_amount');
            $table->string('status'); // PAID /UNPAID
            $table->dateTime('paid_date')->nullable();
            $table->string('receipt_number')->nullable();
            $table->string('paid_amount')->nullable();
            $table->string('invoice_id');
            $table->decimal('balance');
            $table->timestamps();

            $table->foreign('invoice_id')->references('id')->on('invoices')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('debts');
    }
};
