<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInventoriesTable extends Migration
{
    public function up()
    {
        Schema::create('inventories', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('product_id');
            $table->double('quantity');
            $table->double('min');
            $table->timestamps();
        });
    }


    public function down()
    {
        Schema::dropIfExists('inventories');
    }
}
