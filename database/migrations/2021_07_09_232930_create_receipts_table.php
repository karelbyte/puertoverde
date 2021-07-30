<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReceiptsTable extends Migration
{
    public function up()
    {
        Schema::create('receipts', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id');
            $table->date('moment');
            $table->string('doc');
            $table->string('note', 1000);
            $table->double('amount');
            $table->string('status'); // in-progress, apply
            $table->timestamps();

        });
    }


    public function down()
    {
        Schema::dropIfExists('receipts');
    }
}
