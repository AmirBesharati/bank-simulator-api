<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedSmallInteger('transaction_type_id');
            $table->unsignedInteger('sender_account_id')->nullable();
            $table->unsignedInteger('receiver_account_id');
            $table->text('note')->nullable();
            $table->unsignedDouble('amount');
            $table->string('reference_code')->unique();
            $table->timestamps();
            $table->softDeletes();


            $table->foreign('transaction_type_id')->references('id')->on('transaction_types')->onDelete('cascade');
            $table->foreign('sender_account_id')->references('id')->on('accounts')->onDelete('cascade');
            $table->foreign('receiver_account_id')->references('id')->on('accounts')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transactions');
    }
}
