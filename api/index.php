<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type");
header("Access-Control-Allow-Credentials: true");

// display errors
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once dirname(__DIR__) . '/vendor/autoload.php';

use Illuminate\Database\Capsule\Manager as Capsule;
use Controller\GraphQL as GraphQLController;
use Repository\mysql\Product as ProductRepository;
use Resolver\Product as ProductResolver;
use Repository\mysql\Category as CategoryRepository;
use Resolver\Category as CategoryResolver;
use Repository\mysql\Attributes as AttributesRepository;
use Resolver\Attributes as AttributesResolver;
use Repository\mysql\Order as OrderRepository;
use Resolver\Order as OrderResolver;

// Initializing database connection
$config = require_once dirname(__DIR__) . '/config/database.php';
$capsule = new Capsule;
$capsule->addConnection($config);
$capsule->setAsGlobal();
$capsule->bootEloquent();

$productRepository = new ProductRepository();
$productResolver = new ProductResolver($productRepository);
$categoryRepository = new CategoryRepository();
$categoryResolver = new CategoryResolver($categoryRepository);
$attributesRepository = new AttributesRepository();
$attributesResolver = new AttributesResolver($attributesRepository);
$orderRepository = new OrderRepository();
$orderResolver = new OrderResolver($orderRepository);


// echo json_encode($productResolver->getProductById("apple-airpods-pro"));
$resolvers = [
    'product' => $productResolver,
    'category' => $categoryResolver,
    'attributes' => $attributesResolver,
    'order' => $orderResolver
];

$graphQL = new GraphQLController($resolvers);

$graphQL->handleRequest();
