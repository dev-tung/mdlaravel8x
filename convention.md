| Thành phần                   | Quy ước đặt tên                | Ví dụ                                                            |
| ---------------------------- | ------------------------------ | ---------------------------------------------------------------- |
| **Controller**               | PascalCase + `Controller`      | `ProductController`, `CartController`                            |
| **Model**                    | PascalCase (số ít)             | `User`, `Order`, `Product`                                       |
| **Migration (file)**         | snake\_case + số nhiều         | `create_products_table.php`, `add_status_to_orders_table.php`    |
| **Migration (table)**        | snake\_case (số nhiều)         | `products`, `user_orders`                                        |
| **Seeder**                   | PascalCase + `Seeder`          | `ProductSeeder`, `UserSeeder`                                    |
| **Factory**                  | PascalCase + `Factory`         | `UserFactory`, `ProductFactory`                                  |
| **Route (URI)**              | kebab-case                     | `/add-to-cart`, `/product-detail/{id}`                           |
| **Route name**               | snake\_case + dot notation     | `admin.orders.show`, `shop.products.index`                       |
| **Blade view file**          | snake\_case                    | `product_detail.blade.php`, `checkout.blade.php`                 |
| **Blade section/yield**      | snake\_case                    | `@section('main_content')`, `@yield('page_title')`               |
| **Blade component**          | kebab-case                     | `<x-product-card />`, `<x-layout.nav-bar />`                     |
| **CSS class (custom)**       | Algolia/BEM style (PascalCase) | `.ProductCard`, `.ProductCard-Title`, `.ProductCard-Title-large` |
| **Bootstrap/Tailwind class** | Theo framework                 | `container`, `row`, `btn-primary`, `text-center`                 |
| **CSS variable (custom)**    | `--kebab-case`                 | `--primary-color`, `--font-size-base`, `--spacing-lg`            |
| **SCSS/SASS variable**       | `$kebab-case`                  | `$primary-color`, `$font-size-base`, `$spacing-lg`               |
| **JavaScript biến/hàm**      | camelCase                      | `let productId`, `function addToCart()`                          |
| **JavaScript class (ES6)**   | PascalCase                     | `class CartManager {}`                                           |
| **JavaScript file**          | kebab-case                     | `cart-manager.js`, `order-list.js`                               |
| **JavaScript folder**        | kebab-case                     | `orders/`, `users/`, `products/`                                 |
| **Config/env key**           | UPPER\_CASE + snake\_case      | `APP_NAME`, `DB_PASSWORD`                                        |
| **Event (Laravel)**          | PascalCase (quá khứ)           | `OrderCreated`, `UserRegistered`                                 |
| **Listener/Job**             | PascalCase + (Listener/Job)    | `SendEmailNotification`, `ProcessOrderJob`                       |
| **Policy**                   | PascalCase + `Policy`          | `OrderPolicy`, `UserPolicy`                                      |
| **Form Request**             | PascalCase + `Request`         | `StoreProductRequest`, `UpdateUserRequest`                       |
