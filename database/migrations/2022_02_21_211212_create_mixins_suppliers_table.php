<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMixinsSuppliersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mixins_suppliers', function (Blueprint $table) {
            $table->bigIncrements("supplier_id");
            $table->string("supplier_name")->nullable();
            $table->string("supplier_mobile")->nullable();
            $table->double("supplier_total_withdrawals")->default(0.0);
            $table->double("supplier_total_paid")->default(0.0);
            $table->double("supplier_total_remain")->default(0.0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mixins_suppliers');
    }
}
