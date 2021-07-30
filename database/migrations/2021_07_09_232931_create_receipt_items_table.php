<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReceiptItemsTable extends Migration
{
    public function up()
    {
        Schema::create('receipt_items', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('receipt_id');
            $table->bigInteger('product_id');
            $table->double('quantity');
            $table->timestamps();

        });
    }


    public function down()
    {
        Schema::dropIfExists('receipt_items');
    }
}
