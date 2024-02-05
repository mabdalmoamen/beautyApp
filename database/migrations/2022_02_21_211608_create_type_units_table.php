<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTypeUnitsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('type_units', function (Blueprint $table) {
            $table->bigIncrements("type_unit_id");
            $table->decimal("price")->default(0.0);
            $table->foreignId('type_id')->constrained('types', "type_id")->nullable();
            $table->foreignId('unit_id')->constrained('units', "unit_id")->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('type_units');
    }
}
