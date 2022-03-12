<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TblBeritaAcara extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_berita_acara', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->dateTime('tanggal');
            $table->text('detail_kejadian');
            $table->unsignedBigInteger('transaksi_id')->nullable();
            $table->double('nominal_kerugian');
            $table->string('image_pendukung')->nullable();
            $table->tinyInteger('status_masalah'); // 10 = Tertahan 20 = Dalam Proses 30 = Selesai

            $table->tinyInteger('status_aktif');
            $table->unsignedBigInteger('user_created')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();             
            $table->timestamps();

            $table->foreign('user_created')
            ->references('id')
            ->on('tbl_user')
            ->onUpdate('cascade')
            ->onDelete('set null');

            $table->foreign('transaksi_id')
            ->references('id')
            ->on('tbl_transaksi')
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
        //
    }
}
