<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TblTransaksiOffline extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_transaksi_offline', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nama_customer');
            $table->double('total_amount');
            $table->tinyInteger('status_transaksi'); // 10 LUNAS 20 BELUM LUNAS
            $table->double('discount_amount')->nullable();
            $table->unsignedBigInteger('user_created')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();             
            $table->timestamps();

            $table->foreign('user_created')
            ->references('id')
            ->on('tbl_user')
            ->onUpdate('cascade')
            ->onDelete('set null');

            $table->foreign('updated_by')
            ->references('id')
            ->on('tbl_user')
            ->onUpdate('cascade')
            ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tbl_transaksi_offline');
    }
}
