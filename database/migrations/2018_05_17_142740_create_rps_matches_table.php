<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRpsMatchesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rps_matches', function (Blueprint $table) {
            // Columns
            $table->string('id')->index();
            $table->unsignedBigInteger('tx0_index');
            $table->string('tx0_hash');
            $table->string('tx0_address')->index();
            $table->unsignedBigInteger('tx1_index');
            $table->string('tx1_hash');
            $table->string('tx1_address')->index();
            $table->string('tx0_move_random_hash');
            $table->string('tx1_move_random_hash');
            $table->unsignedBigInteger('wager');
            $table->unsignedBigInteger('possible_moves');
            $table->unsignedBigInteger('tx0_block_index');
            $table->unsignedBigInteger('tx1_block_index');
            $table->unsignedBigInteger('block_index')->index();
            $table->unsignedBigInteger('tx0_expiration');
            $table->unsignedBigInteger('tx1_expiration');
            $table->unsignedBigInteger('match_expire_index');
            $table->string('status')->index();
            $table->timestamp('confirmed_at')->nullable();
            $table->timestamps();
            // Indexes
            $table->primary('id');
            $table->index(['status', 'match_expire_index']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rps_matches');
    }
}
