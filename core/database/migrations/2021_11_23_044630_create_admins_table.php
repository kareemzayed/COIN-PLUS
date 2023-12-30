<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdminsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admins', function (Blueprint $table) {
            $table->id();
            $table->string('name',50)->nullable();
            $table->string('username',50)->unique();
            $table->string('email',100)->unique();
            $table->tinyInteger('status')->default(1)->comment("0=>inactive, 1=>active");
            $table->bigInteger('role_id')->nullable();
            $table->tinyInteger('is_owner')->default(0)->comment("1=>owner,0=>not owner");
            $table->string('image',100)->nullable();
            $table->string('password');
            $table->rememberToken();
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
        Schema::dropIfExists('admins');
    }
}
