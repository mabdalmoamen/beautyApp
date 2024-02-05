<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMixinsInfoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mixins_info', function (Blueprint $table) {
            $table->id();
            $table->string("mixins_name")->nullable();
            $table->string("mixins_adress")->nullable();
            $table->string("mixins_mobile")->nullable();
            $table->integer("mixins_vat_val")->default(0);;
            $table->boolean("mixins_price_include_vat");
            $table->string("mixins_note")->nullable();
            $table->string("mixins_logo")->nullable();
            $table->string("mixins_mac_serial")->nullable();
            $table->string("end_support_date")->nullable();
            $table->string("default_lang")->default("en");;
            $table->boolean("render_en_names")->default(false);;
            $table->boolean("bill_with_main_type")->default(true);;
            $table->tinyInteger("bill_type")->default(1);
            $table->boolean("use_type_uints")->default(true);;
            $table->boolean("render_bill_note")->default(false);;
            $table->boolean("render_types_note")->default(false);;
            $table->string("contruct_no")->nullable();
            $table->integer("logo_width")->nullable();
            $table->integer("logo_height")->nullable();
            $table->boolean("type_discount")->default(false);;
            $table->boolean("bill_discount")->default(false);;
            $table->boolean("active_type_offer")->default(false);
            $table->timestamp("offer_start_date")->nullable();
            $table->timestamp("offer_end_date")->nullable();
            $table->integer("offer_value")->default(0);;
            $table->integer("offer_percenet")->default(0);;
            $table->boolean("active_offer")->default(false);
            $table->boolean("process_bills")->default(true);
            $table->foreignId("currency")->constrained("currencies")->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mixins_info');
    }
}
