<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Entities\User;

class CreatePaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id')->references('id')->on(User::$tableName);
            $table->string('email');
            $table->integer('amount');
            $table->string('currency',3);
            $table->string('name');
            $table->integer('status_id');
            $table->text('description')->nullable();
            $table->text('message')->nullable();
            $table->string('attachment')->nullable();
            $table->string('code')->unique();
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
        Schema::dropIfExists('payments');
    }
}
