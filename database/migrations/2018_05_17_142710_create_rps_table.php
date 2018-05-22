<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRpsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rps', function (Blueprint $table) {
            // Columns
            $table->unsignedBigInteger('tx_index')->unique();
            $table->string('tx_hash')->unique();
            $table->unsignedBigInteger('block_index')->index();
            $table->string('source')->index();
            $table->unsignedBigInteger('possible_moves');
            $table->unsignedBigInteger('wager');
            $table->string('move_random_hash');
            $table->unsignedBigInteger('expiration');
            $table->unsignedBigInteger('expire_index');
            $table->string('status')->index();
            $table->timestamp('confirmed_at')->nullable();
            $table->timestamps();
            // Indexes
            $table->primary(['tx_index', 'tx_hash']);
            $table->index(['wager', 'possible_moves']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rps');
    }
}
