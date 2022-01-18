<?php

use App\Models\Customer;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateCustomersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('phone', 15);
            $table->string('email', 100)->nullable();
            $table->string('address')->nullable();
            $table->string('city', 50)->nullable();
            $table->string('postcode', 5)->nullable();
            $table->string('state', 3)->nullable();
            $table->timestamps();
        });

        $users = DB::table('orders')->select(['customer_name', 'customer_phone'])->distinct()->get();

        foreach ($users as $user) {
            $attr['name'] = $user->customer_name;
            $attr['phone'] = $user->customer_phone;
            Customer::create($attr);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('customers');
    }
}
