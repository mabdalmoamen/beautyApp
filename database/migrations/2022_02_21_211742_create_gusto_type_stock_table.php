<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGustoTypeStockTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gusto_type_stock', function (Blueprint $table) {
            $table->id();
            $table->foreignId("type_id")->constrained("types", "type_id");
            $table->foreignId("stock_id")->constrained("gusto_stocks");
            $table->foreignId("unit_id")->constrained("units", "unit_id");
            $table->decimal("mount")->default(0.0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('gusto_type_stock');
    }
}
