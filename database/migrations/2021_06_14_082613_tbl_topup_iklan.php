<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class TblTopupIklan extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
            Schema::create('tbl_topup_iklan', function (Blueprint $table) {
                  $table->bigIncrements('id', 20);
                  $table->unsignedBigInteger('user_created');
                  $table->unsignedBigInteger('user_toko_id')->nullable();
                  $table->double('total_iklan');
                  $table->dateTime('date');

                  $table->timestamps();

                  $table->foreign('user_toko_id')
                  ->references('id')
                  ->on('tbl_user_toko')
                  ->onUpdate('cascade')
                  ->onDelete('cascade');

                  $table->foreign('user_created')
                  ->references('id')
                  ->on('tbl_user')
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
      Schema::dropIfExists('tbl_topup_iklan');
    }
}
