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
        Schema::table('users', function (Blueprint $table) {
            $table->date('birthday_reminder')->after('birthday')->nullable();
        });
        \DB::statement("UPDATE users SET birthday_reminder = DATE_FORMAT(birthday,'2022-%m-%d');");
        \DB::statement("UPDATE users SET birthday_reminder = DATE_FORMAT(birthday,'2023-%m-%d') WHERE birthday_reminder < now(); ");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('birthday_reminder');
        });
    }
};
