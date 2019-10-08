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
         $table->string('invoice_no')->unique()->nullable(false);
         $table->float('value', 8, 2)->nullable();
         $table->dateTimeTz('invoice_date')->nullable(false);
         $table->unsignedBigInteger('store_id')->nullable(false);
         $table->timestamps();

         $table->foreign('store_id')->references('id')->on('stores')->onDelete('restrict');
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
