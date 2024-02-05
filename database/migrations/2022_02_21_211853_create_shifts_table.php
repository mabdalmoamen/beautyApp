<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateShiftsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shifts', function (Blueprint $table) {
            $table->id();
            $table->foreignId("current_user")->constrained("users")->nullable();
            $table->foreignId("recived_user")->constrained("users")->nullable();
            $table->double("starter_point")->default(0.0);
            $table->double("cash")->default(0.0);
            $table->double("later")->default(0.0);
            $table->double("card")->default(0.0);
            $table->double("transfer")->default(0.0);
            $table->double("increase")->default(0.0);
            $table->double("deficit")->default(0.0);
            $table->double("remain")->default(0.0);
            $table->timestamp("starter_date")->nullable();
            $table->timestamp("end_date")->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('shifts');
    }
}
