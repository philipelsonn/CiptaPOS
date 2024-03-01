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
        Schema::create('transaction_header', function (Blueprint $table) {
            $table->id();
            $table->string('payment_method_id')->references('id')->on('payment_methods')->onUpdate('cascade')->onDelete('cascade');
            $table->string('cashier_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
            $table->timestamps('transaction_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaction_headers');
    }
};
