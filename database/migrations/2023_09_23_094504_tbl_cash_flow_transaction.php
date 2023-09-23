<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class TblCashFlowTransaction extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_cash_flow_transaction', function (Blueprint $table) {
            
            $table->bigIncrements('id', 20);
            $table->unsignedBigInteger('cash_flow_camponent_id');
            $table->dateTime('date');
            $table->tinyInteger('type'); // Receipt Spending
            $table->double('amount');
            $table->string('note')->nullable();
            $table->unsignedBigInteger('user_created');
            $table->timestamps();
            
            $table->foreign('cash_flow_camponent_id')
                ->references('id')
                ->on('tbl_cash_flow_component')
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
        Schema::dropIfExists('tbl_cash_flow_transaction');
    }
}
