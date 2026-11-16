# STEFA Product API (Backend)

Laravel REST API for the STEFA product management system. It handles registration, login and logout with Laravel Sanctum bearer tokens, and protects the Product CRUD endpoints with authentication (401) and role-based authorization (403).

The React frontend is in a separate repository: https://github.com/casiken123-cyber/stefa-product-frontend

## Group members

| Name | GitHub |
|---|---|
| Full Name | casiken123-cyber (repository owner) |
| Full Name | kkyle0343 |
| Full Name | orlanyams315-gif |
| Full Name | Tolentinojoven20 |
| Full Name | corteljunvelle113-vel |
| Full Name | ArreyXD-cmd |

## Prerequisites

PHP 8.2 or newer, Composer, and Git. Laravel Herd (Windows/macOS) or `php artisan serve` for running the app.

## Setup

```
git clone https://github.com/casiken123-cyber/stefa-product-backend.git
cd stefa-product-backend
composer install
copy .env.example .env
php artisan key:generate
php artisan migrate
php artisan db:seed --class=ProductSeeder
php artisan storage:link
```

`.env.example` contains placeholders only. The real `.env` is never committed. The default database is SQLite; change the `DB_` values in `.env` to use MySQL.

## Run locally

With Laravel Herd the site is served automatically at `http://<folder-name>.test`.
Otherwise run `php artisan serve` and use `http://127.0.0.1:8000`.

## Creating an administrator

Public registration never creates an admin. Create one in `php artisan tinker`:

```
\App\Models\Admin::create(['name' => 'Admin', 'email' => 'admin@example.com', 'password' => \Illuminate\Support\Facades\Hash::make('choose-a-strong-password')]);
```

Choose your own password. Do not publish real passwords.

## API routes

| Method | Endpoint | Access |
|---|---|---|
| POST | /api/register | Public |
| POST | /api/login | Public (users and admins) |
| POST | /api/logout | Signed-in (revokes the current token) |
| GET | /api/user | Signed-in |
| GET | /api/products | Signed-in (user or admin) |
| GET | /api/products/{id} | Signed-in (user or admin) |
| POST | /api/products | Admin only |
| PUT | /api/products/{id} | Admin only |
| DELETE | /api/products/{id} | Admin only |
| apiResource | /api/orders | Customer only |
| apiResource | /api/admins, /api/order-items | Admin only |

Send the token as `Authorization: Bearer <token>` and `Accept: application/json`.

## Roles and permissions

| Who | Access |
|---|---|
| Guest | May register and log in. Product endpoints return 401. |
| Authenticated user | May list and view products. Create, update and delete return 403. |
| Administrator | May list, view, create, update and delete products. |

Administrators are stored in a separate `admins` table, so the role comes from the server and cannot be chosen at registration. Passwords are hashed with Laravel's `Hash` facade and are never returned. Responses return only `id`, `name`, `email` and `role`.

## Differences from the example API contract

- There is no PATCH route. Update uses PUT. To upload an image while updating, send a POST with the form field `_method=PUT`.
- Products are paginated (15 per page) and wrapped in `{ data, links, meta }`.
- A product image is uploaded as a file named `image` (JPG, PNG or WEBP, up to 2 MB) and returned as `image_url`.
- Products have a `stock` field that is required when creating.

## Testing

All endpoints were tested with curl: guest 401, registration 201, duplicate email 422, login 200, user create 403, admin create 201, update 200, delete 200, and 401 after logout.

## Known limitations

- Uploaded product pictures are not stored in the repository (`storage/app/public` is ignored).
- Tokens do not expire unless revoked by logout.