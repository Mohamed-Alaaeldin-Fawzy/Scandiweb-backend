<?php

namespace Repository\mysql;

use Repository\Product as AbstractProduct;
use Model\Product as ProductModel;

class Product extends AbstractProduct {

    public function getAllProducts(): array {
        try {
            $products = ProductModel::with('category', 'attributes', 'prices', 'gallery')
                                    ->get()
                                    ->toArray();
        } catch (\Exception $e) {
            error_log('Error retrieving products: ' . $e->getMessage());
            return [];
        }

        return array_map(function ($product) {
            return new ProductModel($product); 
        }, $products);
    }

    public function getProductById($id): ProductModel {
        try {
            $product = ProductModel::with('category', 'attributes', 'prices', 'gallery')
                                    ->where('id', $id)
                                    ->first()
                                    ->toArray();
        } catch (\Exception $e) {
            error_log('Error retrieving product: ' . $e->getMessage());
            return null;
        }

        return new ProductModel($product);

}

}
