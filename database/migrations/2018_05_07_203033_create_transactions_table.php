<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            // Columns
            $table->unsignedBigInteger('tx_index');
            $table->unsignedBigInteger('block_index')->index();
            $table->unsignedBigInteger('message_index')->unique()->nullable();
            $table->string('tx_hash')->unique();
            $table->string('type');
            $table->string('source');
            $table->string('destination')->nullable();
            $table->unsignedInteger('quantity')->default(0);
            $table->unsignedBigInteger('quantity_usd')->default(0);
            $table->unsignedInteger('fee')->default(0);
            $table->unsignedBigInteger('fee_usd')->default(0);
            $table->unsignedInteger('size')->default(0);
            $table->unsignedInteger('vsize')->default(0);
            $table->unsignedInteger('inputs')->default(0);
            $table->unsignedInteger('outputs')->default(0);
            $table->json('raw')->nullable();
            $table->boolean('valid');
            $table->unsignedInteger('quality_score')->default(0)->index();
            $table->unsignedBigInteger('timestamp');
            $table->datetime('confirmed_at')->index();
            $table->datetime('processed_at')->nullable()->index();
            $table->timestamps();
            // Indexes
            $table->primary('tx_index');
            $table->index(['tx_index', 'tx_hash', 'block_index']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transactions');
    }
}
