<?php

namespace Controller;

use GraphQL\GraphQL as GraphQLBase;
use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;
use GraphQL\Type\Schema;
use GraphQL\Type\Definition\InputObjectType;

class GraphQL
{
    private $data;

    public function __construct($data) {
        $this->data = $data;
    }

    public function handleRequest()
    {
        $priceType = new ObjectType([
            'name' => 'Price',
            'fields' => [
                'amount' => ['type' => Type::float()],
                'currency' => ['type' => Type::string()],
                'currency_symbol' => ['type' => Type::string()],
            ],
        ]);

        $galleryType = new ObjectType([
            'name' => 'Gallery',
            'fields' => [
                'image_url' => ['type' => Type::string()],
            ]
        ]);

        $attributeItemType = new ObjectType([
            'name' => 'AttributeItem',
            'fields' => [
                'id' => ['type' => Type::id()],
                'attribute_id' => ['type' => Type::id()],
                'display_value' => ['type' => Type::string()],
                'value' => ['type' => Type::string()],
            ],
        ]);

        $attributeType = new ObjectType([
            'name' => 'Attribute',
            'fields' => [
                'id' => ['type' => Type::id()],
                'product_id' => ['type' => Type::id()],
                'name' => ['type' => Type::string()],
                'type' => ['type' => Type::string()],
                'items' => ['type' => Type::listOf($attributeItemType)],
            ],
        ]);

        $categoryType = new ObjectType([
            'name' => 'Category',
            'fields' => [
                'id' => ['type' => Type::id()],
                'name' => ['type' => Type::string()],
            ],
        ]);

        $productType = new ObjectType([
            'name' => 'Product',
            'fields' => [
                'id' => ['type' => Type::id()],
                'name' => ['type' => Type::string()],
                'in_stock' => ['type' => Type::boolean()],
                'gallery' => ['type' => Type::listOf($galleryType)],
                'description' => ['type' => Type::string()],
                'category' => ['type' => $categoryType],
                'attributes' => ['type' => Type::listOf($attributeType)],
                'prices' => ['type' => Type::listOf($priceType)],
                'brand' => ['type' => Type::string()],
            ],
        ]);

        $orderItemType = new ObjectType([
            'name' => 'OrderItem',
            'fields' => [
                'product_id' => ['type' => Type::id()],
                'attributes' => ['type' => Type::listOf($attributeItemType)],
                'quantity' => ['type' => Type::int()],
                'price' => ['type' => Type::float()],
            ],
        ]);

        $orderType = new ObjectType([
            'name' => 'Order',
            'fields' => [
                'id' => ['type' => Type::id()],
                'order_items' => [
                    'type' => Type::listOf($orderItemType),
                    'resolve' => function($order) {
                        return $order->items;
                    }
                ],
            ],
        ]);

        $orderItemInputType = new InputObjectType([
            'name' => 'OrderItemInput',
            'fields' => [
                'product_id' => ['type' => Type::id()],
                'attributes' => ['type' => Type::listOf(Type::id())], 
                'quantity' => ['type' => Type::int()],
                'price' => ['type' => Type::float()],
            ],
        ]);

        $mutationType = new ObjectType([
            'name' => 'Mutation',
            'fields' => [
                'createOrder' => [
                    'type' => $orderType,
                    'args' => [
                        'order_items' => ['type' => Type::listOf($orderItemInputType)],
                    ],
                    'resolve' => [$this->data['order'], 'createOrder'],
                ],
            ],
        ]);

        $queryType = new ObjectType([
            'name' => 'Query',
            'fields' => [
                'categories' => [
                    'type' => Type::listOf($categoryType),
                    'resolve' => [$this->data['category'], 'getAllCategories'],
                ],
                'products' => [
                    'type' => Type::listOf($productType),
                    'resolve' => [$this->data['product'], 'getAllProducts'],
                ],
                'product' => [
                    'type' => $productType,
                    'args' => [
                        'id' => ['type' => Type::string()],
                    ],
                    'resolve' => [$this->data['product'], 'getProductById'],
                ],
                'attributes' => [
                    'type' => Type::listOf($attributeType),
                    'resolve' => [$this->data['attributes'], 'getAllAttributes'],
                ]
            ],
        ]);

        // Create schema
        $schema = new Schema([
            'query' => $queryType,
            'mutation' => $mutationType,
        ]);

        // Handle GraphQL request
        $input = file_get_contents('php://input');
        if (!$input) {
            $output = ['error' => ['message' => 'No input received']];
            header('Content-Type: application/json');
            echo json_encode($output);
            return;
        }

        $decoded = json_decode($input, true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            $output = ['error' => ['message' => 'Invalid JSON received: ' . json_last_error_msg()]];
            header('Content-Type: application/json');
            echo json_encode($output);
            return;
        }

        $query = $decoded['query'] ?? null;
        if (!$query) {
            $output = ['error' => ['message' => 'No query provided']];
            header('Content-Type: application/json');
            echo json_encode($output);
            return;
        }

        $variableValues = $decoded['variables'] ?? null;

        $context = $this->data; // Use the data array as context

        try {
            $result = GraphQLBase::executeQuery($schema, $query, null, $context, $variableValues);
            $output = $result->toArray();
        } catch (\Exception $e) {
            $output = [
                'error' => [
                    'message' => $e->getMessage(),
                ],
            ];
        }

        header('Content-Type: application/json');
        echo json_encode($output);
    }
}
