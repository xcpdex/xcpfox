<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBroadcastsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('broadcasts', function (Blueprint $table) {
            // Columns
            $table->unsignedBigInteger('tx_index');
            $table->unsignedBigInteger('block_index')->index();
            $table->string('tx_hash')->unique();
            $table->string('source')->index();
            $table->decimal('value', 25, 6)->nullable();
            $table->unsignedBigInteger('fee_fraction_int')->nullable();
            $table->mediumText('text')->nullable();
            $table->boolean('locked');
            $table->string('status');
            $table->unsignedBigInteger('timestamp');
            $table->datetime('confirmed_at')->index();
            $table->timestamps();
            // Indexes
            $table->primary('tx_index');
            $table->index(['status', 'source']);
            $table->index(['status', 'source', 'tx_index']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('broadcasts');
    }
}
