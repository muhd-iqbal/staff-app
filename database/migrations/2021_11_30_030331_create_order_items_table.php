<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('order_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('order_id');
            $table->foreign('order_id')->references('id')->on('orders');
            $table->string('product');
            $table->string('size');
            $table->string('quantity');
            $table->text('remarks');
            $table->unsignedBigInteger('user_id')->nullable(); //designer
            $table->foreign('user_id')->references('id')->on('users');
            $table->boolean('isConfirmed')->default(0); //for confirmed order
            $table->timestamp('isConfirmed_time')->nullable();
            $table->boolean('isDesign')->default(0); //on design phase
            $table->timestamp('isDesign_time')->nullable();
            $table->boolean('isApproved')->default(0); //customer approved the design
            $table->timestamp('isApproved_time')->nullable();
            $table->boolean('isPrinting')->default(0); //on print list`
            $table->timestamp('isPrinting_time')->nullable();
            $table->boolean('isFinishing')->default(0); //on finishing phase
            $table->timestamp('isFinishing_time')->nullable();
            $table->boolean('isDone')->default(0); //done processing item
            $table->timestamp('isDone_time')->nullable();
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
        Schema::dropIfExists('order_items');
    }
}
