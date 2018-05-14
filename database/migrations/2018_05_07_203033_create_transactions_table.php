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
            $table->unsignedBigInteger('block_index');
            $table->unsignedBigInteger('tx_index')->unique();
            $table->string('tx_hash')->unique();
            $table->string('type');
            $table->string('source');
            $table->string('destination')->nullable();
            $table->integer('quantity')->unsigned()->default(0);
            $table->integer('fee')->unsigned()->default(0);
            $table->integer('size')->unsigned()->default(0);
            $table->integer('vsize')->unsigned()->default(0);
            $table->integer('inputs')->unsigned()->default(0);
            $table->integer('outputs')->unsigned()->default(0);
            $table->json('raw')->nullable();
            $table->unsignedBigInteger('timestamp');
            $table->timestamp('confirmed_at')->nullable();
            $table->timestamp('processed_at')->nullable();
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
