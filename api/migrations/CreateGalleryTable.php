<?php

use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Database\Schema\Blueprint;

Capsule::schema()->create('gallery', function (Blueprint $table) {
    $table->increments('id');
    $table->string('product_id');
    $table->string('image_url');
    $table->timestamps();

    $table->foreign('product_id')->references('id')->on('products');
});