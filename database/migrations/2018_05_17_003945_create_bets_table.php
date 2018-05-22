<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bets', function (Blueprint $table) {
            // Columns
            $table->unsignedBigInteger('tx_index')->unique();
            $table->string('tx_hash')->unique();
            $table->unsignedBigInteger('block_index')->index();
            $table->string('source')->index();
            $table->string('feed_address');
            $table->unsignedBigInteger('bet_type');
            $table->unsignedBigInteger('deadline');
            $table->unsignedBigInteger('wager_quantity');
            $table->unsignedBigInteger('wager_remaining');
            $table->unsignedBigInteger('counterwager_quantity');
            $table->unsignedBigInteger('counterwager_remaining');
            $table->decimal('target_value');
            $table->unsignedBigInteger('leverage');
            $table->unsignedBigInteger('expiration');
            $table->unsignedBigInteger('expire_index');
            $table->unsignedBigInteger('fee_fraction_int');
            $table->string('status');
            $table->timestamp('confirmed_at')->nullable();
            $table->timestamps();
            // Indexes
            $table->primary(['tx_index', 'tx_hash']);
            $table->index(['status', 'expire_index']);
            $table->index(['feed_address', 'status', 'bet_type']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bets');
    }
}
