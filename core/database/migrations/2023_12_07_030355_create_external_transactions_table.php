<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExternalTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('external_transactions', function (Blueprint $table) {
            $table->id();
            $table->tinyInteger('trans_type')->comment('1=purchase,2=sale')->nullable();
            $table->string('customar_name')->nullable();
            $table->text('details')->nullable();
            $table->decimal('amount', 28, 8)->default(0);
            $table->decimal('charge', 28, 8)->default(0);
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
        Schema::dropIfExists('external_transactions');
    }
}
