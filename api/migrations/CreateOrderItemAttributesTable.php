<?php

use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Database\Schema\Blueprint;

Capsule::schema()->create('order_item_attributes', function (Blueprint $table) {
    $table->increments('id');
    $table->integer('order_item_id')->unsigned();
    $table->integer('attribute_item_id')->unsigned();
    $table->timestamps();

    $table->foreign('order_item_id')->references('id')->on('order_items');
    $table->foreign('attribute_item_id')->references('id')->on('attribute_items');
});