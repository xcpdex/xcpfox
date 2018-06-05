<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBetExpirationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bet_expirations', function (Blueprint $table) {
            // Columns
            $table->unsignedBigInteger('bet_index');
            $table->unsignedBigInteger('block_index')->index();
            $table->string('bet_hash')->unique();
            $table->string('source')->index();
            $table->datetime('confirmed_at')->index();
            $table->timestamps();
            // Indexes
            $table->primary('bet_index');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bet_expirations');
    }
}
