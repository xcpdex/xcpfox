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
            $table->unsignedBigInteger('message_index');
            $table->unsignedBigInteger('block_index')->index();
            $table->string('command');
            $table->string('category');
            $table->json('bindings');
            $table->unsignedBigInteger('timestamp');
            $table->timestamp('confirmed_at')->index();
            $table->timestamps();
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
