<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePurchasesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchases', function (Blueprint $table) {
            $table->id();
            $table->string('item_name', 255)->nullable();
            $table->foreignId('buyer_id')->constrained('users');
            $table->foreignId('seller_id')->constrained('users');
            $table->decimal('amount', 28, 8)->default(0);
            $table->decimal('purchase_cost', 28, 8)->default(0);
            $table->decimal('sales_cost', 28, 8)->default(0);
            $table->decimal('seller_floating_balance', 28, 8)->default(0);
            $table->decimal('buyer_floating_balance', 28, 8)->default(0);
            $table->decimal('charge', 28, 8)->default(0);
            $table->text('note')->nullable();
            $table->string('utr', 255)->nullable();
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
        Schema::dropIfExists('purchases');
    }
}
