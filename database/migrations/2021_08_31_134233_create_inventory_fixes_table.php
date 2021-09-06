<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInventoryFixesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inventory_fixes', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id');
            $table->date('moment');
            $table->string('type')->default('discount'); //add, discount
            $table->string('document')->nullable();
            $table->string('note', 1000);
            $table->double('amount');
            $table->string('status'); // in-progress, apply
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
        Schema::dropIfExists('inventory_fixes');
    }
}
