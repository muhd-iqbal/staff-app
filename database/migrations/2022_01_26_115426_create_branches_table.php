<?php

use App\Models\Branch;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBranchesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('branches', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('shortname', 10);
            $table->string('address');
            $table->string('phone_1');
            $table->string('phone_2')->nullable();
            $table->string('whatsapp_1');
            $table->string('whatsapp_2')->nullable();
            $table->string('bank_account_1');
            $table->string('bank_account_2')->nullable();
            $table->string('bank_account_3')->nullable();
            $table->text('foot_note')->nullable();
            $table->string('color_code');
            $table->timestamps();
        });

        $attributes_1 = [
            'name' => 'Inspirazs Sdn. Bhd.',
            'shortname' => 'gurun',
            'address' => 'Lot 15, Bangunan PKNK Kawasan Perindustrian Ringan Gurun, Kilang Ketapan, 08300 Gurun, Kedah',
            'phone_1' => '044681423',
            'phone_2' => '0193653135',
            'whatsapp_1' => '0135303135',
            'whatsapp_2' => '0193653135',
            'bank_account_1' => 'CIMB BANK 8604614297 (Inspirazs Sdn. Bhd.)',
            'bank_account_2' => 'PUBLIC BANK 3159884900 (Inspirazs Enterprise)',
            'bank_account_3' => 'Maybank 152125317509 (Zamri Seman)',
            'color_code' => 'purple',
        ];

        $attributes_2 = [
            'name' => 'Inspirazs Sdn. Bhd.',
            'shortname' => 'guar',
            'address' => 'No. 8, Kompleks Guar Utama, Jalan Guar Utama 1, 08800 Guar Chempedak, Kedah',
            'phone_1' => '044683135',
            'phone_2' => '01118803135',
            'whatsapp_1' => '01118803135',
            'bank_account_1' => 'CIMB BANK 8604614297 (Inspirazs Sdn. Bhd.)',
            'color_code' => 'pink',
        ];

        Branch::create($attributes_1);
        Branch::create($attributes_2);

        Schema::table('orders', function (Blueprint $table) {
            $table->unsignedBigInteger('branch_id')->after('location')->default(1);
            $table->foreign('branch_id')->references('id')->on('branches');
        });
        Schema::table('order_items', function (Blueprint $table) {
            $table->unsignedBigInteger('branch_id')->after('location')->nullable();
            $table->foreign('branch_id')->references('id')->on('branches');
        });

        // DB::table('orders')->where('location', '=', 'gurun')->update(['branch_id' => 1]);
        DB::table('orders')->where('location', '=', 'guar')->update(['branch_id' => 2]);
        DB::table('order_items')->where('location', '=', 'gurun')->update(['branch_id' => 1]);
        DB::table('order_items')->where('location', '=', 'guar')->update(['branch_id' => 2]);

        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn('location');
        });
        Schema::table('order_items', function (Blueprint $table) {
            $table->dropColumn('location');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->string('location')->after('method');
        });
        Schema::table('order_items', function (Blueprint $table) {
            $table->string('location')->after('is_approved_time');
        });

        DB::table('orders')->where(['branch_id' => 1])->update(['location' => 'gurun']);
        DB::table('orders')->where(['branch_id' => 2])->update(['location' => 'guar']);

        DB::table('order_items')->where(['branch_id' => 1])->update(['location' => 'gurun']);
        DB::table('order_items')->where(['branch_id' => 2])->update(['location' => 'guar']);

        Schema::table('orders', function (Blueprint $table) {
            $table->dropForeign(['branch_id']);
            $table->dropColumn('branch_id');
        });
        Schema::table('order_items', function (Blueprint $table) {
            $table->dropForeign(['branch_id']);
            $table->dropColumn('branch_id');
        });

        Schema::dropIfExists('branches');
    }
}
