<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRollbacksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rollbacks', function (Blueprint $table) {
            // Columns
            $table->increments('id');
            $table->unsignedBigInteger('message_index')->index();
            $table->unsignedBigInteger('block_index')->index();
            $table->datetime('processed_at')->nullable()->index();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rollbacks');
    }
}
