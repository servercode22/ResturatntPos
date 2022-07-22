<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTimeTransactionsTime extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('transactions', function (Blueprint $table) {

        
            $table->string('served_time')->nullable();
            $table->string('served_total_time')->nullable();
            $table->string('total_time')->nullable();
            $table->string('order_status_served')->nullable();
            $table->string('order_status_cooked')->nullable();
            $table->string('update_status')->default('0');
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
