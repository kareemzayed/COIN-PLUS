<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDirectPurchasesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('direct_purchases', function (Blueprint $table) {
            $table->id();
            $table->string('item_name')->nullable();
            $table->tinyInteger('seller_type')->comment('1=on_system,2=on_way')->default(1);
            $table->foreignId('seller_id')->constrained('users')->nullable();
            $table->string('seller_on_way_name')->nullable();
            $table->foreignId('fund_id')->constrained('funds');
            $table->decimal('amount', 28, 8)->default(0);
            $table->decimal('purchase_cost', 28, 8)->default(0);
            $table->decimal('charge', 28, 8)->default(0);
            $table->decimal('fund_floating_balance', 28, 8)->default(0);
            $table->decimal('seller_floating_balance', 28, 8)->default(0);
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
        Schema::dropIfExists('direct_purchases');
    }
}
