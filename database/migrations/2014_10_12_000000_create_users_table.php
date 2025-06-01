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
            $table->string('foto')->nullable();
            $table->string('nama');
            $table->string('no_telp')->unique();
            $table->string('nak')->nullable();
            $table->string('alamat')->nullable();
            $table->string('email')->unique();
            $table->tinyInteger('status')->default(0)->comment('0 -> belum diverifikasi, 1 -> diverifikasi, 2 -> dalam pengawasan');
            $table->string('password');
            $table->rememberToken();
            $table->tinyInteger('role');
            $table->tinyInteger('member')->default(0);
            $table->bigInteger('member_poin')->default(0);
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
