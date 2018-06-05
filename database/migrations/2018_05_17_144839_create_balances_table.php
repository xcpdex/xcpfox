<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBalancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('balances', function (Blueprint $table) {
            // Columns
            $table->increments('id');
            $table->string('address')->index();
            $table->string('asset')->index();
            $table->unsignedBigInteger('quantity');
            $table->unsignedBigInteger('quantity_usd')->default(0);
            $table->unsignedBigInteger('message_index')->index();
            $table->unsignedBigInteger('block_index')->index();
            $table->boolean('current')->index();
            $table->unsignedInteger('quality_score')->default(0)->index();
            $table->datetime('confirmed_at')->index();
            $table->timestamps();
            // Indexes
            $table->index(['address', 'asset']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('balances');
    }
}
