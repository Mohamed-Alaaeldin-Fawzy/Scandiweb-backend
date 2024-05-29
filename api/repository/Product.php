<?php

namespace Repository;

use Model\Product as ModelProduct;

abstract class Product {

  abstract public function getAllProducts() : array;

  abstract public function getProductById($id) : ModelProduct;


}