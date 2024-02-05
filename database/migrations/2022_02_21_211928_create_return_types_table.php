<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReturnTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('return_types', function (Blueprint $table) {
            $table->bigIncrements("return_type_id");
            $table->foreignId('return_id')->constrained('returns', 'return_id');
            $table->foreignId('type_id')->constrained('types', "type_id");
            $table->decimal("type_count")->default(0.0);
            $table->decimal("type_price")->default(0.0);
            $table->decimal("type_total_price")->default(0.0);
            $table->decimal("type_discount")->default(0.0);
            $table->decimal("type_vat")->default(0.0);
            $table->foreignId("sell_unit")->nullable(0.0);
            $table->decimal("type_cost")->default(0.0);
            $table->boolean("returned")->default(true);
            $table->decimal("returned_qty")->default(0.0);
            $table->decimal("returned_total")->default(0.0);
            $table->string("type_note")->nullable(0.0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('return_types');
    }
}
