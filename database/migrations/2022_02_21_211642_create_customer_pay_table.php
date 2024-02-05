<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomerPayTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customer_pay', function (Blueprint $table) {
            $table->bigIncrements("customer_cash_id");
            $table->decimal("paid_value")->default(0.0);
            $table->timestamp("paid_date")->nullable();
            $table->foreignId('cust_id')->constrained('customers', "cust_id")->nullable();
            $table->foreignId("user_id")->constrained("users")->nullable();
            $table->foreignId('pay_method')->constrained('pay_methods')->nullable();
            $table->decimal("cust_after_after")->default(0.0);
            $table->decimal("cust_balance_before")->default(0.0);
            $table->boolean("is_pay")->default(true);
            $table->string("note")->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('customer_pay');
    }
}
