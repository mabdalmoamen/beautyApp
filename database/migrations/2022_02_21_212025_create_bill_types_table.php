<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBillTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bill_types', function (Blueprint $table) {
            $table->bigIncrements("bill_type_id");
            $table->foreignId('bill_no')->constrained('bills', 'bill_no');
            $table->foreignId('type_id')->constrained('types', "type_id");
            $table->decimal("type_count")->default(0.0);
            $table->decimal("type_price")->default(0.0);
            $table->decimal("type_total_price")->default(0.0);
            $table->decimal("type_discount")->default(0.0);
            $table->decimal("type_vat")->default(0.0);
            $table->foreignId("sell_unit")->nullable();
            $table->decimal("type_cost")->default(0.0);
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
        Schema::dropIfExists('bill_types');
    }
}
