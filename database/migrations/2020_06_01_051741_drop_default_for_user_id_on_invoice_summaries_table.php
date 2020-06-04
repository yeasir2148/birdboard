<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DropDefaultForUserIdOnInvoiceSummariesTable extends Migration
{
   /**
   * Run the migrations.
   *
   * @return void
   */
   public function up()
   {
      Schema::table('invoice_summaries', function (Blueprint $table) {
         $table->unsignedBigInteger('user_id')->default(NULL)->change();
      });
   }

   /**
   * Reverse the migrations.
   *
   * @return void
   */
   public function down()
   {
      Schema::table('invoice_summaries', function (Blueprint $table) {
         $table->unsignedBigInteger('user_id')->default(1)->change();
      });
   }
}
