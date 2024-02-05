<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->bigIncrements("cust_id");
            $table->string("cust_name")->nullable();
            $table->string("cust_mobile")->nullable();
            $table->double("cust_address")->nullable();
            $table->decimal("cust_balance")->default(0.0);
            $table->integer("cust_discount_val")->default(0);
            $table->integer("cust_discount_percent")->default(0);
            $table->string("cust_vat_num")->nullable();
            $table->decimal("max_balance")->default(0.0);
            $table->boolean("active_customer")->default(true);
            $table->foreignId('pay_method')->constrained('pay_methods');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('customers');
    }
}
