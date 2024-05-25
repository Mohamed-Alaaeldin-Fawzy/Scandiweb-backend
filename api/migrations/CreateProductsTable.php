<?php

use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Database\Schema\Blueprint;

Capsule::schema()->create('products', function (Blueprint $table) {
    $table->string('id')->primary();
    $table->string('name');
    $table->boolean('in_stock');
    $table->text('description');
    $table->integer('category_id')->unsigned();
    $table->string('brand');
    $table->timestamps();

    $table->foreign('category_id')->references('id')->on('categories');
});