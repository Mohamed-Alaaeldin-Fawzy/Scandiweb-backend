<?php

use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Database\Schema\Blueprint;

Capsule::schema()->create('attribute_items', function (Blueprint $table) {
    $table->increments('id');
    $table->string('attribute_id');
    $table->string('display_value');
    $table->string('value');
    $table->timestamps();

    $table->foreign('attribute_id')->references('id')->on('attributes');
});