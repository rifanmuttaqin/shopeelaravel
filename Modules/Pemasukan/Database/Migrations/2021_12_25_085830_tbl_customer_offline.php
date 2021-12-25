<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TblCustomerOffline extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_customer_offline', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nama');
            $table->string('alamat')->nullable();
            $table->string('no_hp')->nullable();
            $table->string('akun_shopee')->nullable();
           
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
