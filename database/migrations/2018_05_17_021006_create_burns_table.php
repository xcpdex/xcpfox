<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBurnsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('burns', function (Blueprint $table) {
            // Columns
            $table->unsignedBigInteger('tx_index');
            $table->unsignedBigInteger('block_index')->index();
            $table->string('tx_hash')->unique();
            $table->string('source')->index();
            $table->unsignedBigInteger('burned');
            $table->unsignedBigInteger('burned_usd')->default(0);
            $table->unsignedBigInteger('earned');
            $table->unsignedBigInteger('earned_usd')->default(0);
            $table->string('status')->index();
            $table->unsignedInteger('quality_score')->default(0)->index();
            $table->datetime('confirmed_at')->index();
            $table->timestamps();
            // Indexes
            $table->primary('tx_index');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('burns');
    }
}
