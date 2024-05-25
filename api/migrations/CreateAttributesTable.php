<?php

use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Database\Schema\Blueprint;

Capsule::schema()->create('attributes', function (Blueprint $table) {
    $table->string('id');
    $table->string('product_id');
    $table->string('name');
    $table->string('type');
    $table->timestamps();

    $table->foreign('product_id')->references('id')->on('products');
    $table->index('id');
});