<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payment_vouchers', function (Blueprint $table) {
            $table->id();
            $table->string('payee_name');
            $table->string('payee_phone');
            $table->string('payee_bank')->nullable();
            $table->string('payee_acc_no')->nullable();
            $table->date('due_date')->nullable();
            $table->string('payment_method')->nullable();
            $table->integer('total')->default(0);
            $table->string('remarks')->nullable();
            $table->unsignedBigInteger('prepared_by')->nullable();
            $table->foreign('prepared_by')->references('id')->on('users');
            $table->date('prepared_date')->nullable();
            $table->boolean('is_approved')->default(0);
            $table->unsignedBigInteger('approved_by')->nullable();
            $table->foreign('approved_by')->references('id')->on('users');
            $table->date('approved_date')->nullable();
            $table->boolean('is_received')->default(0);
            $table->date('received_date')->nullable();
            $table->timestamps();
        });
        Schema::create('payment_voucher_lists', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('voucher_id');
            $table->foreign('voucher_id')->references('id')->on('payment_vouchers');
            $table->string('title');
            $table->integer('amount');
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
        Schema::dropIfExists('payment_voucher_lists');
        Schema::dropIfExists('payment_vouchers');
    }
};
