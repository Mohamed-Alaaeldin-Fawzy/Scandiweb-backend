<?php

namespace Resolver;

use Repository\mysql\Order as OrderRepository;
use GraphQL\Error\Error;

class Order {
    private OrderRepository $orderRepository;

    public function __construct(OrderRepository $orderRepository) {
        $this->orderRepository = $orderRepository;
    }

    public function createOrder($root, $args, $context) {
        try {
            $orderData = [
                'order_items' => $args['order_items']
            ];
            $result = $this->orderRepository->createOrder($orderData);
            if ($result['success']) {
                return $result['order'];
            } else {
                error_log('Error creating order: ' . $result['message']);
                throw new Error($result['message']);
            }
        } catch (\Exception $e) {
            error_log('Exception in createOrder: ' . $e->getMessage());
            throw new Error('Error creating order: ' . $e->getMessage());
        }
    }
}
