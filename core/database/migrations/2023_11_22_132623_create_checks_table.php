<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChecksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('checks', function (Blueprint $table) {
            $table->id();
            $table->string('check_num')->unique();
            $table->date('issuance_date')->nullable();
            $table->string('beneficiary_name')->nullable();
            $table->string('bank_name')->nullable();
            $table->tinyInteger('status')->default(0)->comment('1=paid,2=cancelled,3=unpaid');
            $table->date('due_date')->nullable();
            $table->decimal('amount', 28, 8)->default(0);
            $table->string('currency')->nullable();
            $table->string('image')->nullable();
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
        Schema::dropIfExists('checks');
    }
}
