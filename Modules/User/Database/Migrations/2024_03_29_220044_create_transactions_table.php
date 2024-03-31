<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('transactions', function (Blueprint $table) {
            // $table->id();
            // $table->dropForeign('transactions_order_id_foreign');
            $table->unsignedBigInteger('user_id');
            // $table->unsignedBigInteger('order_id')->nullable()->change();
            $table->string('transaction_id')->nullable()->change();
            $table->string('payment_method')->nullable()->change();
            $table->string('type');
            $table->double('amount');
            $table->text('note')->nullable();
            // $table->timestamps();
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
};
