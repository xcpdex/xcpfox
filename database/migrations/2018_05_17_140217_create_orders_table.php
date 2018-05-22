<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            // Columns
            $table->unsignedBigInteger('tx_index')->unique();
            $table->string('tx_hash')->unique();
            $table->unsignedBigInteger('block_index')->index();
            $table->string('source')->index();
            $table->string('give_asset')->index();
            $table->unsignedBigInteger('give_quantity');
            $table->unsignedBigInteger('give_quantity_usd')->default(0);
            $table->bigInteger('give_remaining');
            $table->bigInteger('give_remaining_usd')->default(0);
            $table->string('get_asset');
            $table->unsignedBigInteger('get_quantity');
            $table->unsignedBigInteger('get_quantity_usd')->default(0);
            $table->bigInteger('get_remaining');
            $table->bigInteger('get_remaining_usd')->default(0);
            $table->unsignedBigInteger('expiration');
            $table->unsignedBigInteger('expire_index');
            $table->unsignedBigInteger('fee_required');
            $table->bigInteger('fee_required_remaining');
            $table->unsignedBigInteger('fee_provided');
            $table->bigInteger('fee_provided_remaining');
            $table->string('status');
            $table->timestamp('confirmed_at')->nullable();
            $table->timestamps();
            // Indexes
            $table->primary(['tx_index', 'tx_hash']);
            $table->index(['status', 'expire_index']);
            $table->index(['give_asset', 'status']);
            $table->index(['source', 'give_asset', 'status']);
            $table->index(['get_asset', 'give_asset', 'status']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
}
