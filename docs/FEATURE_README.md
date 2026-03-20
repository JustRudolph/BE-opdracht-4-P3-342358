# Feature: Overzicht Geleverde Producten (Delivered Products Overview)

## Overview

This feature allows warehouse managers to view all products that have been delivered to the company within a specified date range. It provides three primary scenarios:

1. **Scenario 01**: View overview of all delivered products within a date range
2. **Scenario 02**: View detailed specifications for a specific product
3. **Scenario 03**: Handle cases where no deliveries exist in the selected period

## Feature Details

### User Story
As a manager, I want to see an overview of all delivered products within a time period so that I can verify if the product inflow is consistent during that period.

### Acceptance Criteria
- ✅ Manager can filter products by start and end date
- ✅ Results display supplier name (A-Z sorted), product name, barcode, total quantity, and delivery count
- ✅ Manager can click to see detailed delivery information per product
- ✅ System displays informative message when no deliveries exist for the period
- ✅ Results are paginated with maximum 4 items per page
- ✅ Pagination provides smooth navigation between pages

## Implementation

### Routes
```
GET /delivered-products                         # Overview page with date filter
GET /delivered-products/{productId}/specifications # Product specifications page
```

### Controllers
- `DeliveredProductsController@index` - Display overview and handle date filtering
- `DeliveredProductsController@specifications` - Display product delivery details

### Views
- `resources/views/delivered-products/index.blade.php` - Overview page
- `resources/views/delivered-products/specifications.blade.php` - Specifications page

### Database
- Table: `product_per_leveranciers` - Stores delivery records
- Table: `products` - Product information
- Table: `leveranciers` - Supplier information
- Stored Procedures:
  - `sp_GetDeliveredProductsByDateRange` - Retrieve products by date
  - `sp_GetProductDeliverySpecifications` - Retrieve delivery details

### Test Data
- Date Range: 2023-04-08 to 2023-04-21
- Sample Records: 18 delivery records across 14 products and 7 suppliers

## Usage

### For End Users

1. **Navigate to feature**:
   - Click "Overzicht Geleverde Producten" on the homepage

2. **Filter by date range**:
   - Enter Start date (e.g., 08-04-2023)
   - Enter End date (e.g., 19-04-2023)
   - Click "Maak selectie"

3. **View results**:
   - Products sorted by supplier name (A-Z)
   - Each row shows: Supplier, Product, Barcode, Total Quantity, Delivery Count
   - Click "?" button for detailed specifications

4. **Navigate pages**:
   - Use pagination controls to view more than 4 items
   - "Vorige" = Previous page
   - "Volgende" = Next page
   - "Eerste" = First page
   - "Laatste" = Last page

### For Developers

#### Adding a New Supplier
```php
$supplier = Leverancier::create([
    'Naam' => 'New Supplier',
    'ContactPersoon' => 'Contact Name',
    'LeverancierNummer' => 'L123456789',
    'Mobiel' => '06-12345678',
    'ContactId' => $contact->id,
    'IsActief' => 1
]);
```

#### Recording a Delivery
```php
ProductPerLeverancier::create([
    'LeverancierId' => $leverancier->id,
    'ProductId' => $product->id,
    'DatumLevering' => '2023-04-10',
    'Aantal' => 50,
    'DatumEerstVolgendeLevering' => '2023-04-17'
]);
```

#### Querying Deliveries
```php
$deliveries = DB::select(
    'CALL sp_GetDeliveredProductsByDateRange(?, ?)',
    ['2023-04-08', '2023-04-15']
);
```

## Technical Architecture

### MVC Structure
- **Model**: `App\Models\ProductPerLeverancier`, `App\Models\Product`, `App\Models\Leverancier`
- **View**: Blade templates in `resources/views/delivered-products/`
- **Controller**: `App\Http\Controllers\DeliveredProductsController`

### Database Layer
- Stored procedures for complex queries
- PDO for database access
- Foreign key relationships enforced at database level

### Pagination
- Default: 4 items per page
- Client-side calculation of pagination parameters
- URL parameters maintained through pagination links

## Testing

### Unit Tests
- Test database retrieval by date range
- Test pagination calculations
- Test product specifications retrieval
- Test data model validation

### Integration Tests
- Test complete user workflows
- Test view rendering with data
- Test form submission
- Test pagination navigation

### Test Execution
```bash
# Run all tests
php artisan test tests/Feature/DeliveredProductsControllerTest.php

# Run with verbose output
php artisan test tests/Feature/DeliveredProductsControllerTest.php --verbose

# Run with testdox format
php artisan test tests/Feature/DeliveredProductsControllerTest.php --testdox
```

## Validation & Error Handling

### Input Validation
- Date fields are required
- HTML5 date input prevents invalid formats
- End date must be >= start date

### Database Validation
- Foreign keys enforced
- IsActief flag checked in queries
- NULL handling for optional fields (DatumEerstVolgendeLevering)

### Error Messages
- "Er zijn geen leveringen geweest van producten in deze periode" - When no results found
- Form validation errors - When required fields missing

## Performance Considerations

### Query Optimization
- Stored procedures use indexed queries
- Date range filtering uses BETWEEN operator
- JOIN operations optimized with proper indexes
- Results cached in application (pagination handled in-memory)

### Pagination Performance
- 4 items per page keeps page loads fast
- No database pagination needed for small result sets
- URL parameters preserved for bookmark-ability

## Future Enhancements

1. **Export functionality** - CSV/PDF export of delivery records
2. **Advanced filtering** - Filter by supplier, allergen type
3. **Charts & analytics** - Visualize delivery patterns
4. **Email notifications** - Alert managers of delivery delays
5. **Delivery forecasting** - Predict future deliveries based on history
6. **Integration with inventory** - Link deliveries to stock levels

## Troubleshooting

### "No deliveries found" message appears for valid date range
- Check if products have IsActief = 1
- Check if delivery records have IsActief = 1
- Verify date format in database (YYYY-MM-DD)
- Check timezone settings (UTC assumed)

### Pagination shows incorrect page count
- Verify 18 test deliveries are loaded
- Check itemsPerPage is set to 4
- Clear Laravel cache if needed

### Stored procedures not executing
- Ensure stored procedures are created on database
- Run: `php artisan db:seed` or manually execute stored_procedures.sql
- Verify MySQL supports stored procedures (SQLite does not)

## Related Documentation

- [Class Diagram](./ClassDiagram.md) - System architecture and relationships
- [Database Specification](./DatabaseSpecification.md) - Detailed table specifications
- [Test Plan](./Testplan.md) - Testing strategy and test cases
- [Test Report](./Testrapport.md) - Test execution results

## Support & Maintenance

For questions or issues related to this feature, contact:
- **Development Team**: [contact info]
- **QA Lead**: [contact info]  
- **Database Admin**: [contact info]

---

## Version History

| Version | Date | Changes |
|---------|------|---------|
| 1.0 | 2026-03-20 | Initial release with 3 scenarios, pagination, and complete test coverage |

---

## Files Modified/Created

### New Files
- `app/Http/Controllers/DeliveredProductsController.php`
- `resources/views/delivered-products/index.blade.php`
- `resources/views/delivered-products/specifications.blade.php`
- `database/scripts/stored_procedures.sql`
- `tests/Feature/DeliveredProductsControllerTest.php`
- `docs/` - Documentation files

### Modified Files
- `routes/web.php` - Added routes for new feature
- `resources/views/home.blade.php` - Added link to feature
- `database/migrations/` - Updated contact table structure
- `database/scripts/create_database.sql` - Updated test data

---

## How to Deploy

1. Ensure database migration is run:
   ```bash
   php artisan migrate
   ```

2. Load test data:
   ```bash
   mysql -u root -p alergeen < database/scripts/create_database.sql
   ```

3. Create stored procedures:
   ```bash
   mysql -u root -p alergeen < database/scripts/stored_procedures.sql
   ```

4. Run tests:
   ```bash
   php artisan test
   ```

5. Access feature at: `http://localhost/delivered-products`

---

This feature is production-ready and has been thoroughly tested.
