<?php

use Facade\Ignition\Tabs\Tab;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterOrderItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // for strange reason I cant make scheme works so here the long sql one
        DB::statement('ALTER TABLE `order_items` ADD `supplier_id` BIGINT UNSIGNED NULL DEFAULT NULL AFTER `is_done_time`;');
        DB::statement('ALTER TABLE `order_items` ADD CONSTRAINT `order_items_supplier_id_foreign` FOREIGN KEY (supplier_id) REFERENCES suppliers(id);');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('order_items', function (Blueprint $table) {
            $table->dropForeign(['supplier_id']);
            $table->dropColumn('supplier_id');
        });
    }
}
