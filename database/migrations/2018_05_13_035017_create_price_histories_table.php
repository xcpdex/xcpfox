<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePriceHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('price_histories', function (Blueprint $table) {
            $table->increments('id');
            $table->string('ticker');
            $table->bigInteger('price')->unsigned()->default(0);
            $table->bigInteger('timestamp')->unsigned()->default(0);
            $table->timestamp('confirmed_at');
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
        Schema::dropIfExists('price_histories');
    }
}
