<?php

use Illuminate\Database\Capsule\Manager as Capsule;

class DatabaseSeeder {
    public function run($data) {

        // Insert categories
        foreach ($data['data']['categories'] as $category) {
            Capsule::table('categories')->insert([
                'name' => $category['name'],
            ]);
        }

        // Insert products and related data
        foreach ($data['data']['products'] as $product) {
            $categoryId = Capsule::table('categories')->where('name', $product['category'])->value('id');

            Capsule::table('products')->insert([
                'id'          => $product['id'],
                'name'        => $product['name'],
                'in_stock'    => $product['inStock'],
                'description' => $product['description'],
                'category_id' => $categoryId,
                'brand'       => $product['brand'],
            ]);

            foreach ($product['attributes'] as $attribute) {
                Capsule::table('attributes')->insert([
                    'id'            => $product['id'] . $attribute['id'],
                    'product_id'    => $product['id'],
                    'name'          => $attribute['name'],
                    'type'          => $attribute['type'],
                ]);

                foreach ($attribute['items'] as $item) {
                    Capsule::table('attribute_items')->insert([
                        'attribute_id'  => $product['id'] . $attribute['id'],
                        'display_value' => $item['displayValue'],
                        'value'         => $item['value'],
                    ]);
                }
            }

            foreach ($product['gallery'] as $gallery) {
                Capsule::table('gallery')->insert([
                    'product_id' => $product['id'],
                    'image_url'  => $gallery,
                ]);
            }

            foreach ($product['prices'] as $price) {
                Capsule::table('prices')->insert([
                    'product_id' => $product['id'],
                    'amount'     => $price['amount'],
                    'currency'   => $price['currency']['label'],
                    'currency_symbol' => $price['currency']['symbol'],
                ]);
            }
        }

        echo 'Data seeded successfully.';
    }
}