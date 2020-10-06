<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class TblCustomer extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_customer', function (Blueprint $table) {
            
            $table->bigIncrements('id', 20);
            $table->string('username_pembeli');
            $table->string('nama_pembeli');
            $table->string('telfon_pembeli');
            $table->string('alamat_pembeli');
            $table->string('kota_pembeli');
            $table->string('provinsi_pembeli');
            $table->string('kode_pos_pembeli');

            $table->unsignedBigInteger('user_created');

            $table->timestamp('created_at')->default(\DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->default(\DB::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'));


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
        Schema::dropIfExists('tbl_customer');
    }
}
