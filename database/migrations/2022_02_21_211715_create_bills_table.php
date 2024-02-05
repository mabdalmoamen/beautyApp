<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBillsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bills', function (Blueprint $table) {
            $table->bigIncrements("bill_no");
            $table->foreignId('cust_id')->constrained('customers', "cust_id");
            $table->decimal("bill_sum")->default(0.0);
            $table->decimal("bill_discount")->default(0.0);
            $table->decimal("bill_total")->default(0.0);
            $table->timestamp("bill_date")->nullable();
            $table->boolean("bill_is_paid")->default(true);
            $table->decimal("bill_extra")->default(0.0);
            $table->decimal("bill_remain_val")->default(0.0);
            $table->decimal("bill_paid_val")->default(0.0);
            $table->string("bill_notes")->nullable();
            $table->foreignId("user_id")->constrained("users")->nullable();
            $table->decimal("bill_vat_val")->default(0.0);
            $table->foreignId('bill_paid_type')->constrained('pay_methods')->nullable();
            $table->decimal("cust_balance_after")->default(0.0);
            $table->decimal("cust_balance_before")->default(0.0);
            $table->boolean("bill_discount_percent")->default(false);
            $table->boolean("returned")->default(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bills');
    }
}
