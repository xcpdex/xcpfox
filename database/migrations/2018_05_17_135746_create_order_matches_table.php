<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrderMatchesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_matches', function (Blueprint $table) {
            // Columns
            $table->string('id');
            $table->unsignedBigInteger('tx0_index')->index();
            $table->string('tx0_hash');
            $table->string('tx0_address')->index();
            $table->unsignedBigInteger('tx1_index')->index();
            $table->string('tx1_hash');
            $table->string('tx1_address')->index();
            $table->string('forward_asset');
            $table->unsignedBigInteger('forward_quantity');
            $table->unsignedBigInteger('forward_quantity_usd')->default(0);
            $table->string('backward_asset');
            $table->unsignedBigInteger('backward_quantity');
            $table->unsignedBigInteger('backward_quantity_usd')->default(0);
            $table->unsignedBigInteger('tx0_block_index');
            $table->unsignedBigInteger('tx1_block_index');
            $table->unsignedBigInteger('block_index')->index();
            $table->unsignedBigInteger('tx0_expiration');
            $table->unsignedBigInteger('tx1_expiration');
            $table->unsignedBigInteger('match_expire_index');
            $table->bigInteger('fee_paid');
            $table->bigInteger('fee_paid_usd')->default(0);
            $table->string('status')->index();
            $table->unsignedInteger('quality_score')->default(0)->index();
            $table->timestamp('confirmed_at')->index();
            $table->timestamps();
            // Indexes
            $table->primary('id');
            $table->index(['status', 'match_expire_index']);
            $table->index(['forward_asset', 'status']);
            $table->index(['backward_asset', 'status']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('order_matches');
    }
}
