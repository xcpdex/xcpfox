<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCreditsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('credits', function (Blueprint $table) {
            // Columns
            $table->increments('id');
            $table->unsignedBigInteger('block_index')->index();
            $table->string('address')->nullable()->index();
            $table->string('asset')->index();
            $table->unsignedBigInteger('quantity');
            $table->unsignedBigInteger('quantity_usd')->default(0);
            $table->string('action');
            $table->string('event');
            $table->unsignedInteger('quality_score')->default(0)->index();
            $table->datetime('confirmed_at')->index();
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
        Schema::dropIfExists('credits');
    }
}
