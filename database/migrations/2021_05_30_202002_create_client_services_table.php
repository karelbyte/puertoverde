<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClientServicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('client_services', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id');
            $table->bigInteger('client_id');
            $table->string('folio');
            $table->string('rate')->nullable();
            $table->string('number_service')->nullable();
            $table->double('average_cost')->nullable();
            $table->bigInteger('annual_kilowatt')->nullable();
            $table->bigInteger('annual_kilowatt_round')->nullable();
            $table->double('annual_cost')->nullable();
            $table->bigInteger('required_units')->nullable();
            $table->double('annual_cost_round')->nullable();
            $table->double('dls_change', 12, 4)->nullable();
            $table->double('panel_capacity')->nullable();
            $table->double('irradiation')->nullable();
            $table->string('note', 1000)->nullable();
            $table->string('status')->default('prospect'); // quote_prospect, single_quote_prospect, quote_client, single_quote_client, quote, single_quote
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
        Schema::dropIfExists('client_services');
    }
}
