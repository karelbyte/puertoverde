<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateServiceQuotesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('service_quotes', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('client_service_id');
            $table->bigInteger('product_id');
            $table->bigInteger('quantity');
            $table->bigInteger('measure_id');
            $table->string('description', 1000);
            $table->double('price');
            $table->double('amount');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('service_quotes');
    }
}
