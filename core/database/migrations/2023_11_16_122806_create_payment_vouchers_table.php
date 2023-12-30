<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentVouchersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payment_vouchers', function (Blueprint $table) {
            $table->id();
            $table->string('receipt_num')->unique()->nullable();
            $table->string('customar_name')->nullable();
            $table->foreignId('currency_id')->constrained('currencies');
            $table->decimal('amount', 28, 8)->default(0);
            $table->string('amount_in_words')->nullable();
            $table->tinyInteger('receipt_type')->default(1)->comment('1 = cash, 2 = check');
            $table->string('check_no')->nullable();
            $table->string('bank')->nullable();
            $table->text('exchange_for')->nullable();
            $table->text('note')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('payment_vouchers');
    }
}
