<?php

namespace Resolver;

use Model\Product as ModelProduct;
use Repository\Product as ProductRepository;

class Product
{
    private ProductRepository $productRepository;

    public function __construct(ProductRepository $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    public function getAllProducts(): array
    {
        $products = $this->productRepository->getAllProducts();
        $data = [];
        foreach ($products as $product) {
            $data[] = [
                'id' => $product->id,
                'name' => $product->name,
                'in_stock' => $product->in_stock,
                'description' => $product->description,
                'category' => $product->category,
                'brand' => $product->brand,
                'attributes' => $product->attributes,
                'prices' => $product->prices,
                'gallery' => $product->gallery,
            ];
        }
        return $data;
    }

    public function getProductById($root, $id, $context): array 
    {
        $product = $this->productRepository->getProductById($id);

        $data = [
            'id' => $product->id,
            'name' => $product->name,
            'in_stock' => $product->in_stock,
            'description' => $product->description,
            'category' => $product->category,
            'brand' => $product->brand,
            'attributes' => $product->attributes,
            'prices' => $product->prices,
            'gallery' => $product->gallery,
        
        ];

        return $data;
        
    }

}
