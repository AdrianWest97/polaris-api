<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsAddressesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('us_addresses', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string("address_line");
            $table->string("city");
            $table->string("state");
            $table->string("zip_code");
             $table->boolean('is_default')->default(false);

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('us_addresses');
    }
}