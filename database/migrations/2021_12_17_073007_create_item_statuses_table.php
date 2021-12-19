<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateItemStatusesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('item_statuses', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('order_item_id');
            $table->foreign('order_item_id')->references('id')->on('order_items');
            $table->boolean('isConfirmed'); //for confirmed order
            $table->boolean('isDesign'); //on design phase
            $table->boolean('isApproved'); //customer approved the design
            $table->boolean('isPrinting'); //on print list
            $table->boolean('isFinishing'); //on finishing phase
            $table->boolean('isDone'); //done processing item
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
        Schema::dropIfExists('item_statuses');
    }
}
