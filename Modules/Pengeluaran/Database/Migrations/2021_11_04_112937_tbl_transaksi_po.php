<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TblTransaksiPo extends Migration
{
      /**
       * Run the migrations.
       *
       * @return void
       */
      public function up()
      {
            Schema::create('tbl_transaksi_po', function (Blueprint $table) {
                  $table->bigIncrements('id');
                  $table->unsignedInteger('produk_po_id');
                  $table->integer('qty');
                  $table->double('total_amount');
                  $table->double('discount_amount')->nullable();
                  $table->text('keterangan')->nullable();
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
            //
      }
}
