<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransaksiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transaksi', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');
            $table->unsignedBigInteger('alamat_pengiriman_id');
            $table->foreign('alamat_pengiriman_id')->references('id')->on('alamat_pengiriman');
            $table->string('no_po');
            $table->bigInteger('total');
            $table->tinyInteger('status')->default(0)->comment('0 -> pesanan terkirim, 1 -> pesanan diterima, 2 -> pesanan selesai, 3 -> pesanan ditolak');
            $table->string('bukti_barang_sampai')->nullable();
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
        Schema::dropIfExists('transaksi');
    }
}
