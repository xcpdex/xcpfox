<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMessagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('messages', function (Blueprint $table) {
            // Columns
            $table->unsignedInteger('message_index');
            $table->unsignedInteger('block_index');
            $table->string('command');
            $table->string('category');
            $table->json('bindings');
            $table->unsignedInteger('timestamp');
            // Indexes
            $table->primary('message_index');
            $table->index(['block_index', 'message_index']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('messages');
    }
}
