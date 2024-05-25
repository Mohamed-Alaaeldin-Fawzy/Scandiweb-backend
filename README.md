# Scandiweb Backend Graphql Api

## Overview

This is a GraphQL API built with native PHP, designed following Object-Oriented Programming (OOP) and SOLID principles. The main functionalities include managing products, categories, Attributes, and orders. The database used is MySQL.

## Folder Structure

```
/my-graphql-api
│
├── /config
│   └── database.php
│
├── /api
│   ├── /Controller
│   │   └── Graphql.php
│   │
│   ├── /Model
│   │   ├── AttributeItem.php
│   │   ├── Attributes.php
│   │   ├── Category.php
│   │   ├── Gallery.php
│   │   ├── Order.php
│   │   └── OrderItem.php
│   │   ├── Prices.php
│   │   ├── Product.php
│   │
│   ├── /repository
│   │   └── /mysql
│   │   |   ├── ProductRepository.php
│   │   |   ├── OrderRepository.php
│   │   |   ├── CategoryRepository.php
│   │   |   └── AttributeRepository.php
│   │   ├── AbstractProductRepository.php
│   │   ├── AbstractOrderRepository.php
│   │   ├── AbstractCategoryRepository.php
│   │   ├── AbstractAttributeRepository.php
│   │
│   ├── /resolver
│   │   ├── Product.php
│   │   ├── Order.php
│   │   ├── Attribute.php
│   │   └── Category.php
│   │
│   └── index.php
│
└── /public
    └── index.php
```

## Installation

1. Clone the repository:

   ```sh
   git clone https://github.com/Mohamed-Alaaeldin-Fawzy/Scandiweb-backend.git
   cd Scandiweb-backend
   ```

2. Install dependencies:

   ```sh
   composer install
   ```

3. Configure the database:

   - Edit the `/config/database.php` file with your MySQL database credentials.

4. Run the database migrations:
   ```sh
   php /path/to/migration/script.php
   ```

## Usage

1. Start the PHP built-in server or configure your web server to serve the project:

   ```sh
   php -S localhost:8000 -t public
   ```

2. Access the GraphQL endpoint at:

   ```
   http://localhost:8000/api/index.php
   ```

3. Use a GraphQL client (e.g., [Insomnia](https://insomnia.rest/), [Postman](https://www.postman.com/), or [GraphiQL](https://github.com/graphql/graphiql)) to interact with the API.

## Example Queries

### Get Products

```graphql
query {
  products {
    id
    description
    name
    prices {
      amount
      currency
      currency_symbol
    }
    in_stock
    gallery {
      image_url
    }

    attributes {
      id
      name
      type
      items {
        id
        display_value
        value
      }
    }

    brand
    category {
      name
    }
  }
}
```

### Create Order

```graphql
mutation ($orderItems: [OrderItemInput!]!) {
  createOrder([array_of_order_items]) {
    id
    order_items {
      product_id
      attributes {
        id
        attribute_id
        display_value
        value
      }
      quantity
      price
    }
  }
}
```

## Project Structure

### Controllers

- **Graphql.php**: Handles GraphQL requests and responses.

### Models

- **Product.php**: Represents a product entity.
- **Category.php**: Represents a category entity.
- **Attributes.php**: Represents an attribute entity.
- **Gallery.php**: Represents a gallery entity.
- **Prices.php**: Represents a price entity.
- **AttributeItem.php**: Represents an attribute item entity.
- **Order.php**: Represents an order entity.
- **OrderItem.php**: Represents an order item entity.

### Repositories

- **AbstractProductRepository.php**: Abstract class for product repository.
- **AbstractOrderRepository.php**: Abstract class for order repository.
- **AbstractCategoryRepository.php**: Abstract class for category repository.
- **AbstractAttributeRepository.php**: Abstract class for attribute repository.
- **mysql/ProductRepository.php**: MySQL implementation of the product repository.
- **mysql/OrderRepository.php**: MySQL implementation of the order repository.
- **mysql/CategoryRepository.php**: MySQL implementation of the category repository.
- **mysql/AttributeRepository.php**: MySQL implementation of the attribute repository.

### Resolvers

- **Product.php**: Resolver for product queries and mutations.
- **Order.php**: Resolver for order queries and mutations.
- **Attribute.php**: Resolver for attribute queries and mutations.
- **Category.php**: Resolver for category queries and mutations.
