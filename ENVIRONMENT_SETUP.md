# Environment Setup Guide - Allergen Overview Project

## Table of Contents
1. [Prerequisites](#prerequisites)
2. [Database Configuration](#database-configuration)
3. [Environment Variables](#environment-variables)
4. [Installation Steps](#installation-steps)
5. [Database Initialization](#database-initialization)
6. [Verification](#verification)
7. [Development Server](#development-server)

## Prerequisites

Ensure you have installed:
- **PHP 8.2+** - Required for Laravel 11
- **Composer** - Dependency manager for PHP
- **MySQL 8.0+** - Database server
- **Xampp/Laragon/Wamp** - Local development environment (recommended)

## Database Configuration

### MySQL Setup

```sql
-- Create database for the project
CREATE DATABASE alergeen CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

-- Create user with privileges
CREATE USER 'alergeen_user'@'localhost' IDENTIFIED BY 'secure_password';
GRANT ALL PRIVILEGES ON alergeen.* TO 'alergeen_user'@'localhost';
FLUSH PRIVILEGES;

-- Verify user creation
SELECT user, host FROM mysql.user WHERE user='alergeen_user';
```

### Database Connection Test

```bash
mysql -h 127.0.0.1 -u alergeen_user -p alergeen
```

## Environment Variables

Create `.env` file by copying `.env.example`:

```bash
cp .env.example .env
```

Update the following values for **MySQL connection**:

```env
APP_NAME=AllergenOverview
APP_ENV=local
APP_KEY=base64:YourBase64Key (run: php artisan key:generate)
APP_DEBUG=true
APP_URL=http://localhost:8000

# Database Configuration (FROM SQLite TO MYSQL)
DB_CONNECTION=mysql          # Changed from sqlite
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=alergeen
DB_USERNAME=alergeen_user
DB_PASSWORD=secure_password  # Use the password you created above

# Mail Configuration (Optional, for contact forms)
MAIL_MAILER=smtp
MAIL_HOST=localhost
MAIL_PORT=1025
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_ENCRYPTION=null

# Session Configuration
SESSION_DRIVER=database
SESSION_LIFETIME=120
```

### Generate Application Key

```bash
php artisan key:generate
```

## Installation Steps

### 1. Install PHP Dependencies

```bash
composer install
```

### 2. Clear Configuration Cache

```bash
php artisan config:clear
php artisan cache:clear
```

### 3. Run Database Migrations

```bash
php artisan migrate
```

### 4. (Optional) Run Database Seeder

For populating test data:

```bash
php artisan db:seed --class=AllergenSeeder
```

Or seed everything:

```bash
php artisan db:seed
```

### 5. Install JavaScript Dependencies (if needed)

```bash
npm install
npm run dev
```

## Database Initialization

### Option A: Migration + Seeder (Recommended)

```bash
# Fresh migration with seeding
php artisan migrate:fresh --seed
```

### Option B: SQL Script Direct Import

If migrations don't work, import the SQL script directly:

```bash
# Via command line
mysql -u alergeen_user -p alergeen < database/sql/create_database.sql
```

Or manually in PhpMyAdmin:
1. Open PhpMyAdmin
2. Go to database "alergeen"
3. Click "Import" tab
4. Select `database/sql/create_database.sql`
5. Click "Go"

### Option C: Stored Procedures

After database creation, load stored procedures:

```bash
mysql -u alergeen_user -p alergeen < database/sql/stored_procedures.sql
```

## Verification

### Check Database Connection

```bash
php artisan tinker

# Inside tinker shell
>>> DB::connection()->getPdo();
>>> DB::table('products')->count();
>>> exit
```

### Check Tables Exist

```bash
php artisan tinker
>>> Schema::getTables();
>>> exit
```

### Test Models Load

```bash
php artisan tinker
>>> App\Models\Product::count();
>>> App\Models\Allergeen::all();
>>> App\Models\Leverancier::all();
>>> exit
```

### Verify Test Data

Should see:
- **Products:** 14 records
- **Allergeens:** 9 records
- **Leveranciers:** 7 records (including 1 with NULL contact)
- **Contacts:** 6 records

## Development Server

### Start Laravel Development Server

```bash
php artisan serve
```

Server runs at: **http://localhost:8000**

### Access Application

- **Homepage:** http://localhost:8000
- **Allergen Overview:** http://localhost:8000/allergeens
- **Allergen 1 (Glutenvrij):** http://localhost:8000/allergeens?allergen_id=1

### Common Routes

```
GET  /                          Home page
GET  /allergeens                Allergen overview with filtering
GET  /allergeens/1/supplier-details   Supplier details for product 1
```

## Troubleshooting

### Issue: "SQLSTATE[HY000] [2002] No such file or directory"
**Solution:** Check MySQL is running and DB_HOST/DB_PORT are correct

### Issue: " SQLSTATE[HY000] [1045] Access denied for user"
**Solution:** Verify DB_USERNAME and DB_PASSWORD in .env match your MySQL credentials

### Issue: "Table 'alergeen.products' doesn't exist"
**Solution:** Run migrations: `php artisan migrate`

### Issue: Model not found errors
**Solution:** Ensure database tables exist and namespaces are correct in models

### Issue: Port 8000 already in use
**Solution:** Use different port: `php artisan serve --port=8001`

## Running Tests

### Run All Tests

```bash
./vendor/bin/phpunit
```

### Run Specific Test File

```bash
./vendor/bin/phpunit tests/Unit/AllergeenControllerTest.php
```

### Run with Verbose Output

```bash
./vendor/bin/phpunit --verbose
```

## Database Backup & Export

### Export Database Schema

```bash
mysqldump -u alergeen_user -p alergeen > database/backup_schema.sql
```

### Export Full Database

```bash
mysqldump -u alergeen_user -p alergeen > database/backup_full.sql
```

## Production Considerations

For production deployment:

```env
APP_ENV=production
APP_DEBUG=false    # Never true in production
SESSION_DRIVER=cookie

# Use environment-specific database credentials
DB_HOST=prod-db.example.com
DB_DATABASE=prod_alergeen
DB_USERNAME=prod_user
DB_PASSWORD=prod_password
```

## Additional Resources

- [Laravel Documentation](https://laravel.com/docs/11.x)
- [MySQL Documentation](https://dev.mysql.com/doc/)
- [Vite Configuration](https://vitejs.dev/)

---

**Last Updated:** December 2025  
**Project:** Allergen Overview (BE-opdracht-4-US01)  
**Laravel Version:** 11.x
