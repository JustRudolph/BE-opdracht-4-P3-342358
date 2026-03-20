# Database Backup and Setup

This directory contains database setup and backup files for the Jamin Warehouse Management System.

## Files

### create_database_complete.sql
Complete database creation script including:
- Database creation
- All table definitions (7 tables)
- Stored procedures (3 procedures)
- Test data (18 delivery records and related data)
- Foreign key constraints
- System fields (IsActief, Opmerking, DatumAangemaakt, DatumGewijzigd)

## Setup Instructions

### Option 1: Complete Setup (Recommended for Development)
```bash
# Navigate to project root
cd c:\Users\Daniello\Desktop\alergeen

# Execute complete database setup
mysql -u root -p < db/setup_database.sql

# Run Laravel migrations
php artisan migrate --seed
```

### Option 2: Manual Setup
1. Create database:
```sql
CREATE DATABASE IF NOT EXISTS alergeen CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE alergeen;
```

2. Run table creation script:
```bash
mysql -u root -p alergeen < database/scripts/create_database.sql
```

3. Run stored procedures:
```bash
mysql -u root -p alergeen < database/scripts/stored_procedures.sql
```

4. Run Laravel migrations:
```bash
php artisan migrate
```

## Test Data

The database is pre-populated with test data for User Story 01:

- **7 Suppliers** (Leveranciers)
- **14 Products** (1 inactive)
- **5 Allergen Types**
- **18 Delivery Records** (April 2023)
- **6 Contact Records** (Contacten)

### Test Date Range
- Start: 2023-04-08
- End: 2023-04-21

This data is used for testing all three scenarios of the user story.

## Database Connection

Configure database connection in `.env`:
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=alergeen
DB_USERNAME=root
DB_PASSWORD=
```

## Verify Setup

After setup, verify all components are in place:

```bash
# Check Laravel migrations
php artisan migrate:status

# Test feature
php artisan serve
# Navigate to: http://localhost:8000/delivered-products
```

## Stored Procedures

Three stored procedures are created:

1. **sp_GetDeliveredProductsByDateRange**
   - Parameters: startDate, endDate
   - Returns: All products delivered in date range

2. **sp_GetProductDeliverySpecifications**
   - Parameters: productId, startDate, endDate
   - Returns: Delivery details for specific product

3. **sp_CountDeliveredProductsByDateRange**
   - Parameters: startDate, endDate
   - Returns: Count of delivered products (output parameter)

## Backup & Recovery

To create a backup:
```bash
mysqldump -u root -p alergeen > db/backup_alergeen_$(date +%Y%m%d_%H%M%S).sql
```

To restore from backup:
```bash
mysql -u root -p alergeen < db/backup_alergeen_20260320.sql
```

## Troubleshooting

### Foreign Key Constraint Errors
- Disable constraint checks temporarily:
  ```sql
  SET FOREIGN_KEY_CHECKS=0;
  -- Run your commands
  SET FOREIGN_KEY_CHECKS=1;
  ```

### Stored Procedure Already Exists
- Procedures are created with `DROP PROCEDURE IF EXISTS`
- Safe to run multiple times

### Wrong Database Encoding
- Ensure database and tables use utf8mb4
- Convert if needed:
  ```sql
  ALTER DATABASE alergeen CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
  ```

## Development Notes

- Test data uses realistic dates and quantities
- All records have IsActief = 1 (active) by default
- System fields are automatically set by database triggers/defaults
- Foreign key relationships are enforced

## Production Deployment

For production:

1. Create separate DB user with limited permissions:
```sql
CREATE USER 'jammaapp'@'localhost' IDENTIFIED BY 'SecurePassword123!';
GRANT SELECT, INSERT, UPDATE, DELETE, EXECUTE ON alergeen.* TO 'jammaapp'@'localhost';
FLUSH PRIVILEGES;
```

2. Use the provided setup script:
```bash
mysql -u jammaapp -p alergeen < db/create_database_complete.sql
```

3. Configure `.env` with production credentials:
```
DB_USERNAME=jammaapp
DB_PASSWORD=SecurePassword123!
```

## Related Documentation

- See `docs/DatabaseSpecification.md` for table details
- See `docs/FEATURE_README.md` for feature deployment
- See `routes/web.php` for route definitions

---

**Last Updated**: March 20, 2026  
**Database Version**: 1.0  
**Laravel Migration Status**: Up to date
