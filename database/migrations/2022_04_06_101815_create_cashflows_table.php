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
        Schema::table('branches', function (Blueprint $table) {
            $table->integer('cash_current');
        });
        Schema::create('cash_categories', function (Blueprint $table) {
            $table->id();
            $table->boolean('in');
            $table->string('name');
        });

        DB::table('cash_categories')->insert([
            ['id' => 1, 'name' => 'Jualan', 'in' => 1],
            ['id' => 2, 'name' => 'Lain-lain', 'in' => 1],
            ['id' => 3, 'name' => 'Pemindahan ke bank', 'in' => 0],
            ['id' => 4, 'name' => 'Barang Ofis', 'in' => 0],
            ['id' => 5, 'name' => 'Utiliti / Bil', 'in' => 0],
            ['id' => 6, 'name' => 'Bayaran Sewa', 'in' => 0],
            ['id' => 7, 'name' => 'Peralatan / Mesin / Perabot', 'in' => 0],
            ['id' => 8, 'name' => 'Lain-lain', 'in' => 0],
        ]);

        Schema::create('cashflows', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->unsignedBigInteger('branch_id')->nullable();
            $table->foreign('branch_id')->references('id')->on('branches');
            $table->unsignedBigInteger('category_id')->nullable();
            $table->foreign('category_id')->references('id')->on('cash_categories');
            $table->unsignedBigInteger('payment_id')->nullable();
            $table->foreign('payment_id')->references('id')->on('payments');
            $table->string('reference');
            $table->integer('amount')->nullable();
            $table->string('note')->nullable();
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
        Schema::dropIfExists('cashflows');

        Schema::dropIfExists('cash_categories');

        Schema::table('branches', function (Blueprint $table) {
            // $table->dropColumn('cash_initial');
            // $table->dropColumn('cash_initial_timestamp');
            $table->dropColumn('cash_current');
        });
    }
};
