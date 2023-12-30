<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransfersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transfers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('sender_currency');
            $table->unsignedBigInteger('receiver_currency');
            $table->string('email');
            $table->decimal('sender_amount',28,8);
            $table->decimal('rate',28,8);
            $table->decimal('charge',28,8);
            $table->decimal('payable_amount',28,8);
            $table->decimal('receiver_amount',28,8);
            $table->string('payment_type');
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
        Schema::dropIfExists('transfers');
    }
}
