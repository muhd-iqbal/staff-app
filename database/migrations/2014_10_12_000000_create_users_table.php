<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('icno')->unique();
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('phone')->unique();
            $table->string('bank_acc')->nullable();
            $table->string('bank_name')->nullable();
            $table->text('address')->nullable();
            $table->foreignId('department_id');
            $table->foreignId('position_id');
            $table->string('qualification')->nullable();
            $table->date('birthday')->nullable();
            $table->integer('annual_leave')->nullable();
            // $table->decimal('leave_remaining',2,1)->nullable();
            $table->date('joined_at');
            $table->date('left_at')->nullable();
            $table->boolean('active');
            $table->text('photo')->nullable();
            $table->boolean('isAdmin')->default(0);
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
