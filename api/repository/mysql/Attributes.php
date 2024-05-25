<?php

namespace Repository\mysql;

use Repository\Attributes as AbstractAttributes;
use Model\Attributes as AttributesModel;
use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Database\QueryException;

class Attributes extends AbstractAttributes {

    public function getAllAttributes(): array {
        try {
            $attributes = AttributesModel::with('items')->get()->map(function ($attributes) {
                return (array) $attributes;
            })->toArray();
        } catch (QueryException $e) {
            error_log('Error retrieving attributes: ' . $e->getMessage());
            return [];
        }
        return array_map(function ($attributes) {
            return new AttributesModel($attributes);
        }, $attributes);
    }

}
