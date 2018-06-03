<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAssetHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('asset_histories', function (Blueprint $table) {
            $table->increments('id');
            $table->string('asset')->index();
            $table->string('type')->index();
            $table->unsignedBigInteger('value')->default(0);
            $table->unsignedInteger('quality_score')->default(0)->index();
            $table->unsignedBigInteger('timestamp');
            $table->timestamp('confirmed_at')->index();
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
        Schema::dropIfExists('asset_histories');
    }
}
