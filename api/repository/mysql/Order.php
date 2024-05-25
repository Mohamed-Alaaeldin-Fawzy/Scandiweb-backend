<?php

namespace Repository\mysql;

use Repository\Order as AbstractOrder;
use Model\Order as OrderModel;
use Model\OrderItem as OrderItemModel;
use Model\AttributeItem as AttributeItemModel;
use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Database\QueryException;

class Order extends AbstractOrder {
    public function createOrder(array $orderData): array {
        Capsule::beginTransaction();

        try {
            // Create the order without specifying the ID
            $order = OrderModel::create([]);

            // Create order items and their attributes
            foreach ($orderData['order_items'] as $item) {
                $orderItem = OrderItemModel::create([
                    'order_id' => $order->id,
                    'product_id' => $item['product_id'],
                    'quantity' => $item['quantity'],
                    'price' => $item['price']
                ]);

                // Attach attribute items to order item
                foreach ($item['attributes'] as $attributeItemId) {
                    $attributeItem = AttributeItemModel::find($attributeItemId);
                    if ($attributeItem) {
                        $orderItem->attributeItems()->attach($attributeItem);
                    } else {
                        error_log("AttributeItem not found: " . $attributeItemId);
                        throw new \Exception("AttributeItem not found: " . $attributeItemId);
                    }
                }
            }

            // Fetch the order with its items and their attributes
            $order = OrderModel::with(['items.attributeItems'])->find($order->id);

            Capsule::commit();
            return [
                'success' => true,
                'order' => $order
            ];

        } catch (QueryException $e) {
            Capsule::rollBack();
            error_log('QueryException in createOrder: ' . $e->getMessage());
            return [
                'success' => false,
                'message' => 'Database error: ' . $e->getMessage()
            ];
        } catch (\Exception $e) {
            Capsule::rollBack();
            error_log('Exception in createOrder: ' . $e->getMessage());
            return [
                'success' => false,
                'message' => 'General error: ' . $e->getMessage()
            ];
        }
    }
}
