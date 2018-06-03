<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDividendsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dividends', function (Blueprint $table) {
            // Columns
            $table->unsignedBigInteger('tx_index');
            $table->string('tx_hash')->unique();
            $table->unsignedBigInteger('block_index')->index();
            $table->string('source')->index();
            $table->string('asset')->index();
            $table->string('dividend_asset')->index();
            $table->unsignedBigInteger('quantity_per_unit');
            $table->unsignedBigInteger('quantity_per_unit_usd')->default(0);
            $table->unsignedBigInteger('fee_paid');
            $table->unsignedBigInteger('fee_paid_usd')->default(0);
            $table->string('status')->index();
            $table->unsignedInteger('quality_score')->default(0)->index();
            $table->timestamp('confirmed_at')->index();
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
        Schema::dropIfExists('dividends');
    }
}
