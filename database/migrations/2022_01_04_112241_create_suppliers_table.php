<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSuppliersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('suppliers', function (Blueprint $table) {
            $table->id('id');
            $table->string('name', 100);
            $table->string('telephone', 15)->nullable();
            $table->string('email', 50)->nullable();
            $table->timestamps();
        });

        DB::table('suppliers')->insert([
            'id' => 1,
            'name' => 'Default Supplier / Subcon',
            'telephone' => '0000000000',
            'email' => 'defaultsupplier@inspirazs.com'
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('suppliers');
    }
}
