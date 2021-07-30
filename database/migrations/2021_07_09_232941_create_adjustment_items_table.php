<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdjustmentItemsTable extends Migration
{
    public function up()
    {
        Schema::create('adjustment_items', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('adjustment_id');
            $table->bigInteger('product_id');
            $table->double('quantity');
            $table->timestamps();

        });
    }


    public function down()
    {
        Schema::dropIfExists('adjustment_items');
    }
}
