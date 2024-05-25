<?php

namespace Repository;

abstract class Order {
  abstract public function createOrder(array $orderData) : array;
}