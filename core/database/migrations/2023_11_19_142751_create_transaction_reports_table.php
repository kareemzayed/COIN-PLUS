<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionReportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transaction_reports', function (Blueprint $table) {
            $table->id();
            $table->foreignId('transaction_id')->constrained('system_transactions')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('user_id')->constrained('users');
            $table->text('reason')->nullable();
            $table->tinyInteger('replied')->default(0)->comment('0=not replied,1=replied');
            $table->text('admin_reply')->nullable();
            $table->decimal('amount_before', 28, 8)->default(0);
            $table->decimal('amount_after', 28, 8)->default(0);
            $table->text('admin_reply')->nullable();
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
        Schema::dropIfExists('transaction_reports');
    }
}
