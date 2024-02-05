<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('types', function (Blueprint $table) {
            $table->bigIncrements("type_id");
            $table->string("type_name_ar")->nullable();
            $table->string("type_name_en")->nullable();
            $table->string("type_icon")->nullable();
            $table->string("type_location")->nullable();
            $table->decimal("type_purchases_price")->default(0.0);
            $table->integer("type_count")->default(0);
            $table->boolean("type_has_vat")->default(true);
            $table->decimal("type_vat_value")->default(0.0);
            $table->integer("type_vat_percent")->default(0);
            $table->string("type_note")->nullable();
            $table->decimal("type_sill_price")->default(0.0);
            $table->decimal("type_discount_value")->default(0.0);
            $table->integer("type_discount_percent")->default(0);
            $table->decimal("total_type_cost")->default(0.0);
            $table->foreignId("main_type")->constrained("mixins_main_types", "main_type_id")->nullable();
            $table->bigInteger("sell_unit")->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('types');
    }
}
