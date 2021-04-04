<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string("name");
            $table->string("description",500);
            $table->boolean("use_url")->default(false);
            $table->string("image_url")->nullable();
            $table->integer("stock");
            $table->double("price");
            $table->string("tags");
            $table->boolean("visible")->default(false);
            $table->boolean("is_featured")->default(false);
            $table->integer("category_id");
            $table->string("caption",100);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
}