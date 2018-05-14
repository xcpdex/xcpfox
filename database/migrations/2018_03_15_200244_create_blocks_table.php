<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBlocksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('blocks', function (Blueprint $table) {
            // Columns
            $table->unsignedBigInteger('block_index');
            $table->string('block_hash')->unique();
            $table->string('ledger_hash')->unique();
            $table->string('txlist_hash')->unique();
            $table->string('messages_hash')->unique();
            $table->string('previous_block_hash')->unique();
            $table->unsignedBigInteger('difficulty');
            $table->unsignedBigInteger('timestamp');
            $table->timestamp('confirmed_at')->nullable();
            $table->timestamps();
            // Indexes
            $table->primary('block_index');
            $table->index(['block_index', 'block_hash']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('blocks');
    }
}
