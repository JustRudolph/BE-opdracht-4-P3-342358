# API & Stored Procedures Documentation

## Overview

User Story 01 implementiert ein RESTful API-Interface für Allergen-Management mit unterstützenden Stored Procedures in MySQL.

---

## HTTP API Endpoints

### 1. Allergen Overview (GET)

**Endpoint:** `/allergeens`\
**Method:** `GET`\
**Description:** Retrieve allergen overview with optional filtering

#### Query Parameters

| Parameter | Type | Required | Description |
|-----------|------|----------|-------------|
| `allergen_id` | Integer | No | Filter by allergen ID (0 or null = all allergens) |

#### Response (200 OK)

```json
{
  "products": {
    "data": [
      {
        "id": 1,
        "Naam": "Mintnopjes",
        "Barcode": "8719587231278",
        "IsActief": true,
        "allergeens": [
          {
            "id": 1,
            "Naam": "Gluten",
            "Omschrijving": "Dit product bevat gluten"
          }
        ]
      }
    ],
    "links": {
      "first": "http://localhost:8000/allergeens?page=1",
      "last": "http://localhost:8000/allergeens?page=3",
      "next": "http://localhost:8000/allergeens?page=2"
    },
    "meta": {
      "current_page": 1,
      "per_page": 4,
      "total": 12
    }
  }
}
```

#### Example Requests

```bash
# All allergens
GET /allergeens

# Filter by Lactose (id=4)
GET /allergeens?allergen_id=4

# Pagination
GET /allergeens?allergen_id=4&page=2
```

---

### 2. Supplier Details (GET)

**Endpoint:** `/allergeens/{productId}/supplier-details`\
**Method:** `GET`\
**Description:** Get supplier information for a specific product

#### URL Parameters

| Parameter | Type | Required | Description |
|-----------|------|----------|-------------|
| `productId` | Integer | Yes | Product ID |

#### Response (200 OK) - With Address

```json
{
  "supplier": {
    "id": 5,
    "Naam": "De Bron",
    "ContactPersoon": "Remco Veenstra",
    "LeverancierNummer": "L1023857736",
    "Mobiel": "06-34291234",
    "contact": {
      "id": 5,
      "Straat": "Leon van Bonstraat",
      "Huisnummer": 213,
      "Postcode": "145XC",
      "Stad": "Lunteren"
    }
  },
  "hasContactInfo": true,
  "product": {
    "id": 12,
    "Naam": "Kruis Drop",
    "Barcode": "8719587322265",
    "allergeens": [
      {
        "id": 4,
        "Naam": "Lactose",
        "Omschrijving": "Dit product bevat lactose"
      }
    ]
  }
}
```

#### Response (200 OK) - Without Address (Scenario 03)

```json
{
  "supplier": {
    "id": 7,
    "Naam": "Hom Ken Food",
    "ContactPersoon": "Hom Ken",
    "LeverancierNummer": "L1029234599",
    "Mobiel": "06-23458477",
    "contact": null
  },
  "hasContactInfo": false,
  "warningMessage": "Er zijn geen adresgegevens bekend"
}
```

#### Response (404 Not Found)

```json
{
  "message": "Product not found"
}
```

#### Example Requests

```bash
# Get supplier for Product 12 (Kruis Drop)
GET /allergeens/12/supplier-details

# Get supplier for Product 14 (Drop Ninja's - no address scenario)
GET /allergeens/14/supplier-details
```

---

## MySQL Stored Procedures

### 1. GetProductsWithAllergens

**Purpose:** Retrieve products with specific allergen, sorted alphabetically

**Syntax:**
```sql
CALL GetProductsWithAllergens(p_allergen_id);
```

**Parameters:**
- `p_allergen_id` (INT): Allergen ID, or 0 for all allergens

**Returns:**
- `id`: Product ID
- `Naam`: Product name (sorted A-Z)
- `Barcode`: EAN barcode
- `IsActief`: Active status
- `AantalAanwezig`: Stock quantity
- `Allergeens`: Comma-separated allergen names

**Example Usage:**

```sql
-- Get all products with Lactose (id=4)
CALL GetProductsWithAllergens(4);

-- Get all products with any allergen
CALL GetProductsWithAllergens(0);
```

**Result Set:**
```
| id | Naam            | Barcode         | IsActief | AantalAanwezig | Allergeens |
|----|-----------------|-----------------|----------|----------------|------------|
| 3  | Honingdrop      | 8719587327836   | 1        | 1              | Lactose    |
| 12 | Kruis Drop      | 8719587322265   | 1        | 467            | Lactose    |
| 13 | Zoute Ruitjes   | 8719587323256   | 1        | 20             | Gluten,... |
```

---

### 2. GetSupplierDetails

**Purpose:** Retrieve supplier and contact information for a product

**Syntax:**
```sql
CALL GetSupplierDetails(p_product_id);
```

**Parameters:**
- `p_product_id` (INT): Product ID

**Returns:**
- `id`: Supplier ID
- `Naam`: Supplier name
- `ContactPersoon`: Contact person name
- `LeverancierNummer`: Supplier number
- `Mobiel`: Mobile number
- `HasContactInfo`: 1 if address available, 0 otherwise
- `Straat`: Street name
- `Huisnummer`: House number
- `Postcode`: Postal code
- `Stad`: City

**Example Usage:**

```sql
-- Get supplier details for Product 12 (with address)
CALL GetSupplierDetails(12);

-- Get supplier details for Product 14 (without address)
CALL GetSupplierDetails(14);
```

**Result Set (With Address):**
```
| id | Naam      | HasContactInfo | Straat              | Huisnummer | Postcode | Stad     |
|----|-----------|----------------|---------------------|------------|----------|----------|
| 5  | De Bron   | 1              | Leon van Bonstraat  | 213        | 145XC    | Lunteren |
```

**Result Set (Without Address):**
```
| id | Naam         | HasContactInfo | Straat | Huisnummer | Postcode | Stad |
|----|--------------|----------------------------------------|---------|
| 7  | Hom Ken Food | 0              |        | 0          |          |      |
```

---

### 3. GetAllergensForProduct

**Purpose:** Get all allergens contained in a product

**Syntax:**
```sql
CALL GetAllergensForProduct(p_product_id);
```

**Parameters:**
- `p_product_id` (INT): Product ID

**Returns:**
- `id`: Allergen ID
- `Naam`: Allergen name
- `Omschrijving`: Description

**Example Usage:**

```sql
-- Get all allergens for Product 1 (Mintnopjes)
CALL GetAllergensForProduct(1);
```

**Result Set:**
```
| id | Naam           | Omschrijving                          |
|----|----------------|---------------------------------------|
| 1  | Gluten         | Dit product bevat gluten              |
| 2  | Gelatine       | Dit product bevat gelatine            |
| 3  | AZO-Kleurstof  | Dit product bevat AZO-kleurstoffen    |
```

---

## Error Handling

### HTTP Status Codes

| Code | Meaning | Example |
|------|---------|---------|
| 200 | OK | Request successful |
| 404 | Not Found | Product or supplier not available |
| 422 | Unprocessable | Invalid filter parameter |
| 500 | Server Error | Database connection error |

### Validation Rules

#### Allergen Filter
- Must be integer
- Must exist in allergeens table
- Can be null (shows all allergens)

#### Product ID
- Must be integer
- Must be > 0
- Product must be IsActief = 1

### Error Response Format

```json
{
  "message": "The given data was invalid",
  "errors": {
    "allergen_id": ["The allergen_id must exist in the allergeens table"]
  }
}
```

---

## Performance Optimization

### Database Indexes (Automatically Created)

```sql
PRIMARY KEY (id) ON products, allergeens, leveranciers, contacts
FOREIGN KEY (ProductId) ON magazijns
FOREIGN KEY (AllergeenId) ON product_per_allergeens
FOREIGN KEY (LeverancierId) ON product_per_leveranciers
```

### Query Optimization

- Stored procedures use efficient JOINs
- IsActief filters reduce result sets
- Sorting done in database, not application
- Pagination limits results to 4 per page

### Caching Opportunities

```php
// Example: Cache allergen list for 1 hour
Cache::remember('allergeens.all', 3600, function () {
    return Allergeen::where('IsActief', true)->get();
});
```

---

## Rate Limiting

No explicit rate limiting implemented. Recommended for production:

```php
// In routes/web.php
Route::middleware(['throttle:60,1'])->group(function () {
    Route::get('/allergeens', [AllergeenController::class, 'index']);
    Route::get('/allergeens/{productId}/supplier-details', 
               [AllergeenController::class, 'supplierDetails']);
});
```

---

## Testing the API

### Using cURL

```bash
# Get allergen overview
curl "http://localhost:8000/allergeens"

# Filter by Lactose
curl "http://localhost:8000/allergeens?allergen_id=4"

# Get supplier details
curl "http://localhost:8000/allergeens/12/supplier-details"
```

### Using Postman

1. Create new GET request
2. URL: `http://localhost:8000/allergeens`
3. Params: `allergen_id=4`
4. Send

---

## Version History

| Version | Date | Changes |
|---------|------|---------|
| 1.0.0 | 2026-03-05 | Initial implementation US01 |

