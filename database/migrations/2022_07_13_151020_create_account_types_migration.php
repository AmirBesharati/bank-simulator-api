<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAccountTypesMigration extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('account_types', function (Blueprint $table) {
            $table->smallIncrements('id');
            $table->string('title')->unique();
            $table->text('description')->nullable();
            $table->unsignedDouble('start_balance');
            $table->softDeletes();
        });


        //add default account types after crating table
        DB::table('account_types')->insert(
            config('enums.account_types')
        );

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('account_types');
    }
}
