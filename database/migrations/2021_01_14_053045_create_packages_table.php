<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePackagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('packages', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('description');
            $table->string('package_number')->unique();
            $table->string('store');
            $table->string('courier');
            $table->string('courier_number')->unique();
            $table->string('currency');
            $table->double('weight');
            $table->string('remarks')->nullable();
            $table->integer('pieces')->nullable();
            $table->integer('pickup_id')->nullable();
            $table->string('tracking_number')->unique();
            $table->integer('user_id');
            $table->double('due_payment')->nullable();
            $table->date('shipment_date');
            $table->integer('status_id')->default(1);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('packages');
    }
}