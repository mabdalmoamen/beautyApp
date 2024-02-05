<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReturnsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('returns', function (Blueprint $table) {
            $table->bigIncrements("return_id");
            $table->foreignId("bill_no")->constrained("bills", "bill_no");
            $table->foreignId("user_id")->constrained("users");
            $table->decimal("vat")->default(0.0);
            $table->decimal("sum")->default(0.0);
            $table->decimal("total")->default(0.0);
            $table->timestamp("returns_date")->nullable();;
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('returns');
    }
}
