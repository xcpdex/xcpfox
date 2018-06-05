<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBetMatchResolutionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bet_match_resolutions', function (Blueprint $table) {
            // Columns
            $table->string('bet_match_id');
            $table->unsignedInteger('bet_match_type_id')->index();
            $table->unsignedBigInteger('block_index')->index();
            $table->string('winner')->nullable();
            $table->boolean('settled')->nullable();
            $table->unsignedBigInteger('bull_credit')->nullable();
            $table->unsignedBigInteger('bull_credit_usd')->default(0);
            $table->unsignedBigInteger('bear_credit')->nullable();
            $table->unsignedBigInteger('bear_credit_usd')->default(0);
            $table->unsignedBigInteger('escrow_less_fee')->nullable();
            $table->unsignedBigInteger('escrow_less_fee_usd')->default(0);
            $table->unsignedBigInteger('fee');
            $table->unsignedBigInteger('fee_usd')->default(0);
            $table->unsignedInteger('quality_score')->default(0)->index();
            $table->datetime('confirmed_at')->index();
            $table->timestamps();
            // Indexes
            $table->primary('bet_match_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bet_match_resolutions');
    }
}
