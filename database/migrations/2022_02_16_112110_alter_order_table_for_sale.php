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
        //add organisation / school name
        Schema::table('customers', function (Blueprint $table) {
            $table->string('organisation')->nullable();
        });

        Schema::table('orders', function (Blueprint $table) {
            $table->integer('total')->default(0);
            $table->integer('discount')->default(0);
            $table->integer('shipping')->default(0);
            $table->integer('grand_total')->default(0);
            $table->string('payment_method', 20)->nullable();
            $table->integer('paid')->default(0);
            $table->integer('due')->default(0);
            $table->integer('payment_status')->default(0);
        });

        //add total on item
        Schema::table('order_items', function (Blueprint $table) {
            $table->integer('total')->after('price');
        });
        // calculate and store total price for single item
        DB::statement("UPDATE `order_items` SET `total` = `price`*`quantity`");

        // calculate and store total price for single order
        $statement = "UPDATE orders od
        INNER JOIN (
          SELECT order_id, SUM(total) as totals
          FROM order_items
          GROUP BY order_id
        ) oi ON od.id = oi.order_id
        SET od.total = oi.totals";
        DB::statement($statement);
        DB::statement("UPDATE orders SET grand_total = total + shipping - discount, due = grand_total - paid");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('customers', function (Blueprint $table) {
            $table->dropColumn('organisation');
        });

        Schema::table('orders', function (Blueprint $table) {
            // $table->dropForeign(['customer_id']);
            $table->dropColumn('total');
            $table->dropColumn('discount');
            $table->dropColumn('shipping');
            $table->dropColumn('grand_total');
            $table->dropColumn('payment_method');
            $table->dropColumn('paid');
            $table->dropColumn('due');
            $table->dropColumn('payment_status');
        });

        Schema::table('order_items', function (Blueprint $table) {
            $table->dropColumn('total');
        });
    }
};
