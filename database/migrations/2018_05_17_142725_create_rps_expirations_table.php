<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRpsExpirationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rps_expirations', function (Blueprint $table) {
            // Columns
            $table->unsignedBigInteger('rps_index')->unique();
            $table->string('rps_hash')->unique();
            $table->string('source')->index();
            $table->unsignedBigInteger('block_index')->index();
            $table->timestamp('confirmed_at')->nullable();
            $table->timestamps();
            // Indexes
            $table->primary('rps_index');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rps_expirations');
    }
}
