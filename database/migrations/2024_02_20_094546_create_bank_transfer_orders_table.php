<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bank_transfer_orders', function (Blueprint $table) {
            $table->id();
            $table->string('order_number')->unique();
            $table->unsignedBigInteger('client_id'); 
            $table->decimal('total_amount', 10, 2);
            $table->string('payment_reference')->unique();
            $table->string('bank_name')->nullable();
            $table->string('account_number')->nullable();
            $table->enum('payment_status', ['pending', 'confirmed', 'cancelled'])->default('pending');
            $table->timestamps();
            $table->timestamp('confirmed_at')->nullable();

            $table->foreign('client_id')->references('id')->on('clients');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bank_transfer_orders');
    }
};
