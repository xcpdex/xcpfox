<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrderExpirationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_expirations', function (Blueprint $table) {
            // Columns
            $table->unsignedBigInteger('order_index');
            $table->unsignedBigInteger('block_index')->index();
            $table->string('order_hash')->unique();
            $table->string('source')->index();
            $table->datetime('confirmed_at')->index();
            $table->timestamps();
            // Indexes
            $table->primary('order_index');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('order_expirations');
    }
}
