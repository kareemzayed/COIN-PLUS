<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSystemTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('system_transactions', function (Blueprint $table) {
            $table->id();
			$table->integer('transactional_id');
			$table->string('transactional_type');
			$table->decimal('charge', 18, 8)->default(0);
			$table->decimal('amount', 18, 8)->default(0);
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
        Schema::dropIfExists('system_transactions');
    }
}
