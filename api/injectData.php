<?php

ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);

require_once dirname(__DIR__) . '/vendor/autoload.php';

use Illuminate\Database\Capsule\Manager as Capsule;

$dotenv = Dotenv\Dotenv::createImmutable(dirname(__DIR__));
$dotenv->load();

$dbHost = $_ENV['DB_HOST'];
$dbDatabase = $_ENV['DB_DATABASE'];
$dbUsername = $_ENV['DB_USERNAME'];
$dbPassword = $_ENV['DB_PASSWORD'];

$config = require_once dirname(__DIR__) . '/config/database.php';

$capsule = new Capsule;
$capsule->addConnection($config);
$capsule->setAsGlobal();
$capsule->bootEloquent();

// Run Migrations
require_once dirname(__DIR__) . '/api/migrations/CreateCategoriesTable.php';
require_once dirname(__DIR__) . '/api/migrations/CreateProductsTable.php';
require_once dirname(__DIR__) . '/api/migrations/CreateAttributesTable.php';
require_once dirname(__DIR__) . '/api/migrations/CreateAttributeItemsTable.php';
require_once dirname(__DIR__) . '/api/migrations/CreateGalleryTable.php';
require_once dirname(__DIR__) . '/api/migrations/CreatePricesTable.php';
require_once dirname(__DIR__) . '/api/migrations/CreateOrdersTable.php';
require_once dirname(__DIR__) . '/api/migrations/CreateOrderItemsTable.php';
require_once dirname(__DIR__) . '/api/migrations/CreateOrderItemAttributesTable.php';

// getting data
$data = json_decode(file_get_contents(dirname(__DIR__) . '/api/data.json'), true);

// Run Seeder
require_once dirname(__DIR__) . '/api/seeders/DatabaseSeeder.php';

$seeder = new DatabaseSeeder();
$seeder->run($data);

echo 'Migrations and seeding completed successfully.';