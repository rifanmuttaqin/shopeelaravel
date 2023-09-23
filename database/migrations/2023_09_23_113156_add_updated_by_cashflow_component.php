<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUpdatedByCashflowComponent extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('tbl_cash_flow_component')) {
            
            Schema::table('tbl_cash_flow_component', function($table) {
                $table->unsignedBigInteger('updated_by');
                $table->foreign('updated_by')
                ->references('id')
                ->on('tbl_user')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            });
        }
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
