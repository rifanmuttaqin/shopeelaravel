<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class TblTransaksi extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_transaksi', function (Blueprint $table) {
            
            $table->bigIncrements('id', 20);
            $table->unsignedBigInteger('user_created');
            $table->unsignedBigInteger('user_toko_id')->nullable();

            $table->string('no_resi');
            $table->string('no_pesanan');
            $table->dateTime('tgl_pesanan_dibuat');
            $table->string('status_pesanan');
            $table->string('status_pembatalan')->nullable();
            $table->dateTime('deadline_pengiriman');
            $table->text('produk');
            $table->string('jasa_kirim');

            $table->string('username_pembeli');
            $table->string('nama_pembeli');
            $table->string('telfon_pembeli');
            $table->string('alamat_pembeli');
            $table->string('kota_pembeli');
            $table->string('provinsi_pembeli');
            $table->string('kode_pos_pembeli');

            $table->integer('status_cetak')->default(10);

            $table->timestamp('created_at')->default(\DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->default(\DB::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'));
            
            $table->foreign('user_created')
            ->references('id')
            ->on('tbl_user')
            ->onUpdate('cascade')
            ->onDelete('cascade');

            $table->foreign('user_toko_id')
            ->references('id')
            ->on('tbl_user_toko')
            ->onUpdate('cascade')
            ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tbl_transaksi');
    }
}
