<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TblProduk extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_produk', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nama_produk');
            $table->string('sku_induk')->nullable();
            $table->double('harga');
            $table->double('harga_grosir_satu')->nullable();
            $table->double('harga_grosir_dua')->nullable();
            $table->double('minimal_pengambilan_satu')->nullable();
            $table->double('minimal_pengambilan_dua')->nullable();
            $table->tinyInteger('is_grosir');
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
        Schema::dropIfExists('tbl_produk');
    }
}
