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
            $table->integer('price');
            $table->string('design_status');
            $table->string('finishing')->nullable();
            $table->text('remarks')->nullable();
            $table->boolean('is_urgent')->default(0);
            $table->unsignedBigInteger('user_id')->nullable(); //designer
            $table->foreign('user_id')->references('id')->on('users');
            $table->boolean('printing_list')->default(0);
            $table->boolean('is_design')->default(0); //on design phase
            $table->timestamp('is_design_time')->nullable();
            $table->boolean('is_approved')->default(0); //customer approved the design
            $table->timestamp('is_approved_time')->nullable();
            $table->boolean('is_printing')->default(0); //on print list`
            $table->timestamp('is_printing_time')->nullable();
            $table->boolean('is_done')->default(0); //done processing item
            $table->timestamp('is_done_time')->nullable();
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
