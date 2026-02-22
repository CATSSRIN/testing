# Ship Order Management System

A Laravel-based ship supply order management system with support for English and Indonesian languages, and IDR (Indonesian Rupiah) currency.

## Features

- **Multi-language support**: Switch between English (EN) and Indonesian (ID) via the navigation bar
- **IDR Currency**: All prices displayed in Indonesian Rupiah (Rp)
- **Order management**: Users can place supply orders for their ships
- **Admin panel**: Manage vendors, products, orders, and users
- **PDF Invoices**: Generate and download order invoices

## Requirements

- PHP 8.2 or higher
- Composer
- Node.js & NPM
- MySQL / MariaDB (or any supported Laravel database)

## Setup Instructions

### 1. Clone the Repository

```bash
git clone <repository-url>
cd testing
```

### 2. Install PHP Dependencies

```bash
composer install
```

### 3. Install Node.js Dependencies

```bash
npm install
```

### 4. Configure Environment

Copy the example environment file and update it with your settings:

```bash
cp .env.example .env
```

Open `.env` and configure your database connection:

```env
APP_NAME="Ship Order"
APP_URL=http://localhost

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=ship_order
DB_USERNAME=your_db_user
DB_PASSWORD=your_db_password
```

### 5. Generate Application Key

```bash
php artisan key:generate
```

### 6. Run Database Migrations

```bash
php artisan migrate
```

### 7. Seed the Database

This will create the admin user and sample vendors/products with IDR prices:

```bash
php artisan db:seed
```

Default admin credentials:
- **Email**: `admin@shiporder.com`
- **Password**: `password`

### 8. Build Frontend Assets

For development:

```bash
npm run dev
```

For production:

```bash
npm run build
```

### 9. Start the Application

```bash
php artisan serve
```

Visit `http://localhost:8000` in your browser.

---

## Language Switching

The application supports **English** and **Indonesian** languages. To switch the language, click the **EN** or **ID** toggle buttons in the navigation bar (top right area, next to your user menu).

- **EN** — English interface
- **ID** — Bahasa Indonesia interface

The selected language is saved in the session and persists across page navigations.

---

## Currency

All prices are displayed in **Indonesian Rupiah (Rp)**. The IDR format uses a period (`.`) as the thousands separator (e.g., `Rp 520.000`).

---

## Running Tests

```bash
php artisan test
```

---

## License

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
