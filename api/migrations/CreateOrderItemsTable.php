<?php

use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Database\Schema\Blueprint;

Capsule::schema()->create('order_items', function (Blueprint $table) {
    $table->increments('id');
    $table->integer('order_id')->unsigned();
    $table->string('product_id');
    $table->integer('quantity');
    $table->decimal('price', 10, 2);
    $table->timestamps();

    $table->foreign('order_id')->references('id')->on('orders');
    $table->foreign('product_id')->references('id')->on('products');
});