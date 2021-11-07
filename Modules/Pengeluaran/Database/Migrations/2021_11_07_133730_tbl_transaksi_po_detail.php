<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TblTransaksiPoDetail extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
            Schema::create('tbl_transaksi_po_detail', function (Blueprint $table) {
                  $table->bigIncrements('id');
                  $table->unsignedBigInteger('id_transaksi_po');
                  $table->string('nama_produk');
                  $table->string('harga_produk');
                  $table->string('qty_beli');
                  $table->tinyInteger('status_aktif');
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
            Schema::dropIfExists('tbl_transaksi_po_detail');
    }
}
