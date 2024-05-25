<?php

namespace Repository\mysql;

use Repository\Category as AbstractCategory;
use Model\Category as CategoryModel;
use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Database\QueryException;

class Category extends AbstractCategory {
  
  public function getAllCategories(): array {
    try {
        $categories = Capsule::table('categories')->get()->map(function ($category) {
            return (array) $category;
        })->toArray();
    } catch (QueryException $e) {
        error_log('Error retrieving categories: ' . $e->getMessage());
        return [];
    }

    return array_map(function ($category) {
        return new CategoryModel($category);
    }, $categories);
}

}