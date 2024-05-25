<?php

use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Database\Schema\Blueprint;

Capsule::schema()->create('prices', function (Blueprint $table) {
    $table->increments('id');
    $table->string('product_id');
    $table->decimal('amount', 10, 2);
    $table->string('currency', 3);
    $table->string('currency_symbol', 3);
    $table->timestamps();

    $table->foreign('product_id')->references('id')->on('products');
});