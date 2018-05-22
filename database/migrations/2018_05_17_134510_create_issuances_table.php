<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIssuancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('issuances', function (Blueprint $table) {
            // Columns
            $table->unsignedBigInteger('tx_index')->unique();
            $table->string('tx_hash')->unique();
            $table->unsignedBigInteger('block_index')->index();
            $table->string('asset');
            $table->unsignedBigInteger('quantity');
            $table->boolean('divisible');
            $table->string('source')->index();
            $table->string('issuer');
            $table->boolean('transfer');
            $table->boolean('callable');
            $table->unsignedBigInteger('call_date');
            $table->decimal('call_price');
            $table->text('description');
            $table->unsignedBigInteger('fee_paid');
            $table->boolean('locked');
            $table->string('status')->index();
            $table->string('asset_longname')->nullable();
            $table->timestamp('confirmed_at')->nullable();
            $table->timestamps();
            // Indexes
            $table->primary('tx_index');
            $table->index(['asset', 'status']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('issuances');
    }
}
