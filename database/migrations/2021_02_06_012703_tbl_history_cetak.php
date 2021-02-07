<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class TblHistoryCetak extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_history_cetak', function (Blueprint $table) {
            $table->bigIncrements('id', 20);
            $table->unsignedBigInteger('user_created');
            $table->string('date_range');
            $table->unsignedBigInteger('user_toko_id')->nullable();
            $table->string('array_user')->nullable();
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
        //
    }
}
