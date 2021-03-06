<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInvoiceDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
   public function up()
   {
      Schema::create('invoice_details', function (Blueprint $table) {
         $table->bigIncrements('id');
         $table->unsignedBigInteger('invoice_id')->nullable(false);
         $table->unsignedBigInteger('item_id')->nullable(false);
         $table->float('quantity', 8, 2)->nullable(false);
         $table->unsignedBigInteger('unit_id')->nullable(false);
         $table->float('price', 8, 2)->nullable(false);
         $table->timestamps();

         $table->foreign('invoice_id')->references('id')->on('invoice_summaries')->onDelete('restrict');
         $table->foreign('item_id')->references('id')->on('items')->onDelete('restrict');
         $table->foreign('unit_id')->references('id')->on('units')->onDelete('restrict');
      });
   }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('invoice_details');
    }
}
