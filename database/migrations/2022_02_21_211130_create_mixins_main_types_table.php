<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMixinsMainTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mixins_main_types', function (Blueprint $table) {
            $table->bigIncrements("main_type_id");
            $table->string("main_type_title_ar")->nullable();;
            $table->String("main_type_title_en")->nullable();;
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mixins_main_types');
    }
}
