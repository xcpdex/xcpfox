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
            $table->unsignedBigInteger('bet_index')->unique();
            $table->string('bet_hash')->unique();
            $table->string('source')->index();
            $table->unsignedBigInteger('block_index')->index();
            $table->timestamp('confirmed_at')->nullable();
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
