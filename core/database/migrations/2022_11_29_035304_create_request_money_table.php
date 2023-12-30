<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRequestMoneyTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('request_money', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('request_user_id');
            $table->unsignedBigInteger('receiver_user_id');
            $table->decimal('request_amount',28,8);
            $table->integer('status')->comment('0=>requested, 1 => approved , 2=> rejected');
            $table->text('reason_of_request')->nullable();
            $table->text('reason_of_reject')->nullable();
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
        Schema::dropIfExists('request_money');
    }
}
