<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('table_types', function (Blueprint $table) {
            $table->bigIncrements("table_type_id");
            $table->foreignId('table_bill_id')->constrained('tables_bill')->nullable();
            $table->foreignId('type_id')->constrained('types', "type_id")->nullable();
            $table->decimal("type_count")->default(0.0);
            $table->decimal("type_price")->default(0.0);
            $table->decimal("type_total_price")->default(0.0);
            $table->decimal("type_discount")->default(0.0);
            $table->decimal("type_vat")->default(0.0);
            $table->foreignId("sell_unit")->default(0.0);
            $table->decimal("type_cost")->nullable();
            $table->string("type_note")->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('table_types');
    }
}
