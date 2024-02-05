<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTablesBillTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tables_bill', function (Blueprint $table) {
            $table->id();
            $table->decimal("bill_sum")->default(0.0);
            $table->decimal("bill_discount")->default(0.0);
            $table->decimal("bill_total")->default(0.0);
            $table->boolean("bill_is_paid");
            $table->decimal("bill_extra")->default(0.0);
            $table->decimal("bill_remain_val")->default(0.0);
            $table->decimal("bill_paid_val")->default(0.0);
            $table->string("bill_notes")->nullable();
            $table->foreignId('table_id')->constrained('tables')->nullable();
            $table->foreignId('cust_id')->constrained('customers', "cust_id")->nullable();
            $table->foreignId("user_id")->constrained("users")->nullable();
            $table->foreignId("sell_unit")->constrained("type_units", "type_unit_id")->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tables_bill');
    }
}
