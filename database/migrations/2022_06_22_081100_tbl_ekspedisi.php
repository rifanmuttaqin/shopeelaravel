<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class TblEkspedisi extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_ekspedisi', function (Blueprint $table) {
            $table->bigIncrements('id', 20);
            $table->unsignedBigInteger('user_created');
            $table->string('ekspedisi_name');
            $table->string('ekspedisi_kode');
            $table->string('ekspedisi_kurir_pickup')->nullable();
            $table->string('ekspedisi_kurir_number')->nullable();
            $table->string('ekspedisi_droppoint_address')->nullable();

            $table->timestamps();

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
