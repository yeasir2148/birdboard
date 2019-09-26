<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInvoiceSummariesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('invoice_summaries', function (Blueprint $table) {
         $table->bigIncrements('id');
         $table->unsignedBigInteger('invoice_no')->unique();
         $table->float('value', 8, 2)->nullable();
         $table->dateTimeTz('invoice_date');
         $table->unsignedBigInteger('store_id')->nullable();
         $table->timestamps();

         $table->foreign('store_id')->references('id')->on('stores')->onDelete('set null');
      });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('invoice_summaries');
    }
}
