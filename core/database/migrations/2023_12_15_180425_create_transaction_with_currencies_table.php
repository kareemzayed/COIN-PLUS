<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionWithCurrenciesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transaction_with_currencies', function (Blueprint $table) {
            $table->id();
            $table->tinyInteger('trans_type')->comment('1=purchase,2=sale')->nullable();
            $table->foreignId('currency_id')->constrained('currencies');
            $table->decimal('amount_in_base_currency', 28, 8)->default(0);
            $table->decimal('amount_in_other_currency', 28, 8)->default(0);
            $table->tinyInteger('charge_type')->comment('1=fixed,2=percentage')->nullable();
            $table->string('charge_value')->nullable();
            $table->decimal('charge', 28, 8)->default(0);
            $table->text('note')->nullable();
            $table->string('utr')->nullable();
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
        Schema::dropIfExists('transaction_with_currencies');
    }
}
