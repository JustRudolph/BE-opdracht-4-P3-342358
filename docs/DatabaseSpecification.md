# Database Specification - Jamin Warehouse Management System

## Overview
This document describes the complete database schema for the Jamin Warehouse Management System, including all 7 tables, their columns, data types, constraints, and relationships.

---

## Table: CONTACTS

| Column Name | Data Type | Length | Null | PK | FK | Description |
|------------|-----------|--------|------|----|----|-------------|
| id | BIGINT UNSIGNED | - | NO | YES | NO | Primary Key, Auto-increment |
| Straat | VARCHAR | 100 | NO | NO | NO | Street name of the contact |
| Huisnummer | VARCHAR | 10 | NO | NO | NO | House number (can include letters like 34a) |
| Postcode | VARCHAR | 10 | NO | NO | NO | Postal code in format (e.g., 1045CB) |
| Stad | VARCHAR | 100 | NO | NO | NO | City name |
| IsActief | BIT | - | NO | NO | NO | Indicates if contact is active (0=inactive, 1=active) |
| Opmerking | VARCHAR | 255 | YES | NO | NO | Additional remarks/notes |
| DatumAangemaakt | DATETIME(6) | - | NO | NO | NO | Timestamp when record was created |
| DatumGewijzigd | DATETIME(6) | - | NO | NO | NO | Timestamp when record was last modified |

**Constraints**: PRIMARY KEY (id)

**Sample Data Count**: 6 records

---

## Table: LEVERANCIERS (Suppliers)

| Column Name | Data Type | Length | Null | PK | FK | Description |
|------------|-----------|--------|------|----|----|-------------|
| id | BIGINT UNSIGNED | - | NO | YES | NO | Primary Key, Auto-increment |
| Naam | VARCHAR | 100 | NO | NO | NO | Supplier company name |
| ContactPersoon | VARCHAR | 100 | NO | NO | NO | Name of contact person |
| LeverancierNummer | VARCHAR | 20 | NO | NO | NO | Unique supplier number |
| Mobiel | VARCHAR | 20 | NO | NO | NO | Mobile phone number |
| ContactId | BIGINT UNSIGNED | - | YES | NO | YES | Foreign Key to CONTACTS table |
| IsActief | BIT | - | NO | NO | NO | Indicates if supplier is active |
| Opmerking | VARCHAR | 255 | YES | NO | NO | Additional remarks |
| DatumAangemaakt | DATETIME(6) | - | NO | NO | NO | Timestamp when record was created |
| DatumGewijzigd | DATETIME(6) | - | NO | NO | NO | Timestamp when record was last modified |

**Constraints**: 
- PRIMARY KEY (id)
- FOREIGN KEY (ContactId) REFERENCES CONTACTS(id) ON DELETE SET NULL

**Sample Data Count**: 7 records

---

## Table: PRODUCTS

| Column Name | Data Type | Length | Null | PK | FK | Description |
|------------|-----------|--------|------|----|----|-------------|
| id | BIGINT UNSIGNED | - | NO | YES | NO | Primary Key, Auto-increment |
| Naam | VARCHAR | 100 | NO | NO | NO | Product name (e.g., Mintnopjes) |
| Barcode | VARCHAR | 20 | NO | NO | NO | Product barcode for scanning |
| IsActief | BIT | - | NO | NO | NO | Indicates if product is active (0=discontinued) |
| Opmerking | VARCHAR | 255 | YES | NO | NO | Additional remarks |
| DatumAangemaakt | DATETIME(6) | - | NO | NO | NO | Timestamp when record was created |
| DatumGewijzigd | DATETIME(6) | - | NO | NO | NO | Timestamp when record was last modified |

**Constraints**: PRIMARY KEY (id)

**Sample Data Count**: 14 records (1 inactive)

---

## Table: ALLERGEENS

| Column Name | Data Type | Length | Null | PK | FK | Description |
|------------|-----------|--------|------|----|----|-------------|
| id | BIGINT UNSIGNED | - | NO | YES | NO | Primary Key, Auto-increment |
| Naam | VARCHAR | 100 | NO | NO | NO | Allergen name (e.g., Gluten) |
| Omschrijving | VARCHAR | 255 | NO | NO | NO | Description of the allergen |
| IsActief | BIT | - | NO | NO | NO | Indicates if allergen is tracked |
| Opmerking | VARCHAR | 255 | YES | NO | NO | Additional remarks |
| DatumAangemaakt | DATETIME(6) | - | NO | NO | NO | Timestamp when record was created |
| DatumGewijzigd | DATETIME(6) | - | NO | NO | NO | Timestamp when record was last modified |

**Constraints**: PRIMARY KEY (id)

**Sample Data Count**: 5 records

---

## Table: PRODUCT_PER_ALLERGEENS

| Column Name | Data Type | Length | Null | PK | FK | Description |
|------------|-----------|--------|------|----|----|-------------|
| id | BIGINT UNSIGNED | - | NO | YES | NO | Primary Key, Auto-increment |
| ProductId | BIGINT UNSIGNED | - | NO | NO | YES | Foreign Key to PRODUCTS table |
| AllergeenId | BIGINT UNSIGNED | - | NO | NO | YES | Foreign Key to ALLERGEENS table |
| IsActief | BIT | - | NO | NO | NO | Indicates if relationship is active |
| Opmerking | VARCHAR | 255 | YES | NO | NO | Additional remarks |
| DatumAangemaakt | DATETIME(6) | - | NO | NO | NO | Timestamp when record was created |
| DatumGewijzigd | DATETIME(6) | - | NO | NO | NO | Timestamp when record was last modified |

**Constraints**: 
- PRIMARY KEY (id)
- FOREIGN KEY (ProductId) REFERENCES PRODUCTS(id) ON DELETE CASCADE
- FOREIGN KEY (AllergeenId) REFERENCES ALLERGEENS(id) ON DELETE CASCADE

**Sample Data Count**: 13 records

---

## Table: MAGAZIJNS (Warehouse)

| Column Name | Data Type | Length | Null | PK | FK | Description |
|------------|-----------|--------|------|----|----|-------------|
| id | BIGINT UNSIGNED | - | NO | YES | NO | Primary Key, Auto-increment |
| ProductId | BIGINT UNSIGNED | - | NO | NO | YES | Foreign Key to PRODUCTS table |
| VerpakkingsEenheid | DECIMAL | 8,2 | NO | NO | NO | Packaging unit (e.g., 5 units per package) |
| AantalAanwezig | INT | - | YES | NO | NO | Current quantity in stock (nullable) |
| IsActief | BIT | - | NO | NO | NO | Indicates if warehouse entry is active |
| Opmerking | VARCHAR | 255 | YES | NO | NO | Additional remarks |
| DatumAangemaakt | DATETIME(6) | - | NO | NO | NO | Timestamp when record was created |
| DatumGewijzigd | DATETIME(6) | - | NO | NO | NO | Timestamp when record was last modified |

**Constraints**: 
- PRIMARY KEY (id)
- FOREIGN KEY (ProductId) REFERENCES PRODUCTS(id) ON DELETE CASCADE

**Sample Data Count**: 14 records

---

## Table: PRODUCT_PER_LEVERANCIERS

| Column Name | Data Type | Length | Null | PK | FK | Description |
|------------|-----------|--------|------|----|----|-------------|
| id | BIGINT UNSIGNED | - | NO | YES | NO | Primary Key, Auto-increment |
| LeverancierId | BIGINT UNSIGNED | - | NO | NO | YES | Foreign Key to LEVERANCIERS table |
| ProductId | BIGINT UNSIGNED | - | NO | NO | YES | Foreign Key to PRODUCTS table |
| DatumLevering | DATE | - | NO | NO | NO | Date when product was delivered |
| Aantal | INT | - | NO | NO | NO | Quantity delivered |
| DatumEerstVolgendeLevering | DATE | - | YES | NO | NO | Scheduled date for next delivery (nullable) |
| IsActief | BIT | - | NO | NO | NO | Indicates if delivery record is active |
| Opmerking | VARCHAR | 255 | YES | NO | NO | Additional remarks |
| DatumAangemaakt | DATETIME(6) | - | NO | NO | NO | Timestamp when record was created |
| DatumGewijzigd | DATETIME(6) | - | NO | NO | NO | Timestamp when record was last modified |

**Constraints**: 
- PRIMARY KEY (id)
- FOREIGN KEY (LeverancierId) REFERENCES LEVERANCIERS(id) ON DELETE CASCADE
- FOREIGN KEY (ProductId) REFERENCES PRODUCTS(id) ON DELETE CASCADE

**Sample Data Count**: 18 records

---

## Entity Relationship Diagram

```
CONTACTS (1) -------- (M) LEVERANCIERS
            (ContactId)

LEVERANCIERS (1) -------- (M) PRODUCT_PER_LEVERANCIERS
             (id)          (LeverancierId)

PRODUCTS (1) -------- (M) PRODUCT_PER_LEVERANCIERS
           (id)     (ProductId)

PRODUCTS (1) -------- (M) PRODUCT_PER_ALLERGEENS
           (id)     (ProductId)

ALLERGEENS (1) -------- (M) PRODUCT_PER_ALLERGEENS
            (id)     (AllergeenId)

PRODUCTS (1) -------- (1) MAGAZIJNS
           (id)          (ProductId)
```

---

## Key Data Characteristics

### Test Data Date Range
- All delivery dates are in April 2023 (2023-04-08 to 2023-04-21)
- Used for testing Scenario 01 and Scenario 02

### System Fields
- All tables include: IsActief, Opmerking, DatumAangemaakt, DatumGewijzigd
- DatumAangemaakt is set to CURRENT_TIMESTAMP on creation
- DatumGewijzigd is updated automatically on every modification

### Relationships
- All Foreign Keys use ON DELETE CASCADE except ContactId in LEVERANCIERS (ON DELETE SET NULL)
- Total of 7 tables with 3 junction/bridge tables (PRODUCT_PER_ALLERGEENS, PRODUCT_PER_LEVERANCIERS)

### Data Integrity
- 14 Products (1 inactive: Winegums)
- 7 Suppliers (6 active profiles + 1 new: Hom Ken Food)
- 5 Allergen types tracked
- 13 Product-Allergen relationships
- 18 Delivery records for April 2023

---

## SQL Specifications

- **Engine**: InnoDB (for ACID compliance)
- **Character Set**: utf8mb4 (supports full Unicode)
- **Collation**: utf8mb4_unicode_ci (case-insensitive)

---

## Notes for Development

1. **Pagination**: User Story 01 implements pagination with 4 records per page
2. **Sorting**: Default sort order is by Leverancier name (A-Z)
3. **Date Filtering**: All date-based queries use BETWEEN operator
4. **Null Handling**: AantalAanwezig and DatumEerstVolgendeLevering can be NULL
5. **Soft Delete**: IsActief field allows logical deletion without removing data
