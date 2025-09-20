# 📘 Naming Conventions

Quy ước đặt tên trong dự án Laravel + Frontend.  
Mục tiêu: **thống nhất – dễ đọc – dễ bảo trì – dễ mở rộng**.

---

## 📑 Mục lục
1. [Backend (Laravel)](#1-backend-laravel)  
2. [Database](#2-database)  
3. [Routes & Views](#3-routes--views)  
4. [Frontend (CSS/JS)](#4-frontend-cssjs)  
5. [Config & Env](#5-config--env)  

---

## 1. Backend (Laravel)

| Thành phần        | Quy ước đặt tên                | Ví dụ                                  |
| ----------------- | ------------------------------ | -------------------------------------- |
| **Controller**    | PascalCase + `Controller`      | `ProductController`, `CartController`  |
| **Model**         | PascalCase (số ít)             | `User`, `Order`, `Product`             |
| **Observer**      | PascalCase + `Observer`        | `UserObserver`, `OrderObserver`        |
| **Middleware**    | PascalCase                     | `Authenticate`, `CheckAdmin`           |
| **Service class** | PascalCase + `Service`         | `PaymentService`, `ReportService`      |
| **Helper func**   | snake_case                     | `format_currency()`, `generate_token()`|
| **Policy**        | PascalCase + `Policy`          | `OrderPolicy`, `UserPolicy`            |
| **Form Request**  | PascalCase + `Request`         | `StoreProductRequest`, `UpdateUserRequest` |
| **Resource (API)**| PascalCase + `Resource`        | `UserResource`, `OrderResource`        |
| **Notification**  | PascalCase                     | `OrderShipped`, `ResetPassword`        |
| **Enum (PHP 8.1)**| PascalCase                     | `OrderStatus`, `UserRole`              |
| **Event**         | PascalCase (quá khứ)           | `OrderCreated`, `UserRegistered`       |
| **Listener/Job**  | PascalCase + (Listener/Job)    | `SendEmailNotification`, `ProcessOrderJob` |
| **Command (class)**| PascalCase                    | `SendReport`, `CleanLogs`              |
| **Command (name)**| kebab-case                     | `php artisan send-report`              |
| **Test class**    | PascalCase + `Test`            | `UserTest`, `OrderControllerTest`      |
| **Test method**   | camelCase                      | `testUserCanLogin()`, `testOrderCheckout()` |

---

## 2. Database

| Thành phần             | Quy ước đặt tên                | Ví dụ                                      |
| ---------------------- | ------------------------------ | ------------------------------------------ |
| **Migration (file)**   | snake_case + số nhiều          | `create_products_table.php`, `add_status_to_orders_table.php` |
| **Migration (table)**  | snake_case (số nhiều)          | `products`, `user_orders`                  |
| **Cột (column)**       | snake_case                     | `created_at`, `updated_at`, `price_input`  |
| **Pivot table**        | snake_case (số ít, alpha order)| `order_product`, `role_user`               |
| **Index/constraint**   | snake_case                     | `user_email_unique`, `orders_user_id_fk`   |
| **Seeder**             | PascalCase + `Seeder`          | `ProductSeeder`, `UserSeeder`              |
| **Factory**            | PascalCase + `Factory`         | `UserFactory`, `ProductFactory`            |

---

## 3. Routes & Views

| Thành phần            | Quy ước đặt tên                | Ví dụ                                      |
| --------------------- | ------------------------------ | ------------------------------------------ |
| **Route (URI)**       | kebab-case                     | `/add-to-cart`, `/product-detail/{id}`     |
| **Route name**        | snake_case + dot notation      | `admin.orders.show`, `shop.products.index` |
| **Blade file**        | snake_case                     | `product_detail.blade.php`, `checkout.blade.php` |
| **Blade section/yield**| snake_case                    | `@section('main_content')`, `@yield('page_title')` |
| **Blade component**   | kebab-case                     | `<x-product-card />`, `<x-layout.nav-bar />` |

---

## 4. Frontend (CSS/JS)

| Thành phần                   | Quy ước đặt tên                | Ví dụ                                                            |
| ---------------------------- | ------------------------------ | ---------------------------------------------------------------- |
| **CSS class (custom)**       | Algolia/BEM (PascalCase)       | `.ProductCard`, `.ProductCard-Title`, `.ProductCard-Title-large` |
| **Bootstrap/Tailwind class** | Theo framework                 | `container`, `row`, `btn-primary`, `text-center`                 |
| **CSS variable (custom)**    | `--kebab-case`                 | `--primary-color`, `--font-size-base`, `--spacing-lg`            |
| **SCSS/SASS variable**       | `$kebab-case`                  | `$primary-color`, `$font-size-base`, `$spacing-lg`               |
| **JS biến/hàm**              | camelCase                      | `let productId`, `function addToCart()`                          |
| **JS class (ES6)**           | PascalCase                     | `class CartManager {}`                                           |
| **JS file**                  | kebab-case                     | `cart-manager.js`, `order-list.js`                               |
| **JS folder**                | kebab-case                     | `orders/`, `users/`, `products/`                                 |

---

## 5. Config & Env

| Thành phần      | Quy ước đặt tên              | Ví dụ                  |
| --------------- | ---------------------------- | ---------------------- |
| **Config key**  | snake_case                   | `app.name`, `database.connections.mysql` |
| **.env key**    | UPPER_CASE + snake_case      | `APP_NAME`, `DB_PASSWORD`                |

---
