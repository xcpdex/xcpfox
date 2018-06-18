<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ReplaceMessageWithTxIndexOnAssetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('assets', function (Blueprint $table) {
            $table->dropColumn('message_index');
            $table->unsignedBigInteger('tx_index')->default(0)->index()->after('block_index');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('assets', function (Blueprint $table) {
            $table->dropColumn('tx_index');
            $table->unsignedBigInteger('message_index')->default(0)->index()->after('block_index');
        });
    }
}
