<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->String('customer_name');
            $table->String('customer_phone');
            $table->date('date');
            $table->date('dateline')->nullable();
            $table->String('method');
            // $table->String('product')->nullable();
            // $table->text('remarks');
            // $table->boolean('isDesign')->default(0);
            // $table->boolean('isPrinting')->default(0);
            $table->boolean('isDone')->default(0);
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
        Schema::dropIfExists('orders');
    }
}
