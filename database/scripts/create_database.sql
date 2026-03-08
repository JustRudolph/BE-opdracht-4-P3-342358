-- ============================================================
-- Database Creation Script for Jamin Warehouse Management
-- Created: 2025-12-13
-- Description: Creates all tables with relationships and sample data
-- ============================================================

-- Create database if it doesn't exist
CREATE DATABASE IF NOT EXISTS alergeen CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE alergeen;

-- Drop tables if they exist (in correct order due to foreign keys)
DROP TABLE IF EXISTS product_per_leveranciers;
DROP TABLE IF EXISTS product_per_allergeens;
DROP TABLE IF EXISTS magazijns;
DROP TABLE IF EXISTS allergeens;
DROP TABLE IF EXISTS products;
DROP TABLE IF EXISTS leveranciers;

-- ============================================================
-- Table: leveranciers (Suppliers)
-- ============================================================
CREATE TABLE leveranciers (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    Naam VARCHAR(100) NOT NULL,
    ContactPersoon VARCHAR(100) NOT NULL,
    LeverancierNummer VARCHAR(20) NOT NULL,
    Mobiel VARCHAR(20) NOT NULL,
    IsActief TINYINT(1) DEFAULT 1,
    Opmerking VARCHAR(255) NULL,
    DatumAangemaakt DATETIME(6) DEFAULT CURRENT_TIMESTAMP(6),
    DatumGewijzigd DATETIME(6) DEFAULT CURRENT_TIMESTAMP(6) ON UPDATE CURRENT_TIMESTAMP(6)
);

-- ============================================================
-- Table: products (Products)
-- ============================================================
CREATE TABLE products (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    Naam VARCHAR(100) NOT NULL,
    Barcode VARCHAR(20) NOT NULL,
    IsActief TINYINT(1) DEFAULT 1,
    Opmerking VARCHAR(255) NULL,
    DatumAangemaakt DATETIME(6) DEFAULT CURRENT_TIMESTAMP(6),
    DatumGewijzigd DATETIME(6) DEFAULT CURRENT_TIMESTAMP(6) ON UPDATE CURRENT_TIMESTAMP(6)
);

-- ============================================================
-- Table: magazijns (Warehouse)
-- ============================================================
CREATE TABLE magazijns (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    ProductId BIGINT UNSIGNED NOT NULL,
    VerpakkingsEenheid DECIMAL(8,2) NOT NULL,
    AantalAanwezig INT NULL,
    IsActief TINYINT(1) DEFAULT 1,
    Opmerking VARCHAR(255) NULL,
    DatumAangemaakt DATETIME(6) DEFAULT CURRENT_TIMESTAMP(6),
    DatumGewijzigd DATETIME(6) DEFAULT CURRENT_TIMESTAMP(6) ON UPDATE CURRENT_TIMESTAMP(6),
    FOREIGN KEY (ProductId) REFERENCES products(id) ON DELETE CASCADE
);

-- ============================================================
-- Table: allergeens (Allergens)
-- ============================================================
CREATE TABLE allergeens (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    Naam VARCHAR(100) NOT NULL,
    Omschrijving VARCHAR(255) NOT NULL,
    IsActief TINYINT(1) DEFAULT 1,
    Opmerking VARCHAR(255) NULL,
    DatumAangemaakt DATETIME(6) DEFAULT CURRENT_TIMESTAMP(6),
    DatumGewijzigd DATETIME(6) DEFAULT CURRENT_TIMESTAMP(6) ON UPDATE CURRENT_TIMESTAMP(6)
);

-- ============================================================
-- Table: product_per_allergeens (Product-Allergen Junction)
-- ============================================================
CREATE TABLE product_per_allergeens (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    ProductId BIGINT UNSIGNED NOT NULL,
    AllergeenId BIGINT UNSIGNED NOT NULL,
    IsActief TINYINT(1) DEFAULT 1,
    Opmerking VARCHAR(255) NULL,
    DatumAangemaakt DATETIME(6) DEFAULT CURRENT_TIMESTAMP(6),
    DatumGewijzigd DATETIME(6) DEFAULT CURRENT_TIMESTAMP(6) ON UPDATE CURRENT_TIMESTAMP(6),
    FOREIGN KEY (ProductId) REFERENCES products(id) ON DELETE CASCADE,
    FOREIGN KEY (AllergeenId) REFERENCES allergeens(id) ON DELETE CASCADE
);

-- ============================================================
-- Table: product_per_leveranciers (Product-Supplier Junction with Delivery Info)
-- ============================================================
CREATE TABLE product_per_leveranciers (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    LeverancierId BIGINT UNSIGNED NOT NULL,
    ProductId BIGINT UNSIGNED NOT NULL,
    DatumLevering DATE NOT NULL,
    Aantal INT NOT NULL,
    DatumEerstVolgendeLevering DATE NULL,
    IsActief TINYINT(1) DEFAULT 1,
    Opmerking VARCHAR(255) NULL,
    DatumAangemaakt DATETIME(6) DEFAULT CURRENT_TIMESTAMP(6),
    DatumGewijzigd DATETIME(6) DEFAULT CURRENT_TIMESTAMP(6) ON UPDATE CURRENT_TIMESTAMP(6),
    FOREIGN KEY (LeverancierId) REFERENCES leveranciers(id) ON DELETE CASCADE,
    FOREIGN KEY (ProductId) REFERENCES products(id) ON DELETE CASCADE
);

-- ============================================================
-- Insert Sample Data: Leveranciers
-- ============================================================
INSERT INTO leveranciers (Naam, ContactPersoon, LeverancierNummer, Mobiel) VALUES
('Venco', 'Bert van Linge', 'L1029384719', '06-28493827'),
('Astra Sweets', 'Jasper del Monte', 'L1029284315', '06-39398734'),
('Haribo', 'Sven Stalman', 'L1029324748', '06-24383291'),
('Basset', 'Joyce Stelterberg', 'L1023845773', '06-48293823'),
('De Bron', 'Remco Veenstra', 'L1023857736', '06-34291234'),
('Quality Street', 'Johan Nooij', 'L1029234586', '06-23458456');

-- ============================================================
-- Insert Sample Data: Products
-- ============================================================
INSERT INTO products (Naam, Barcode, IsActief) VALUES
('Mintnopjes', '8719587231278', 1),
('Schoolkrijt', '8719587326713', 1),
('Honingdrop', '8719587327836', 1),
('Zure Beren', '8719587321441', 1),
('Cola Flesjes', '8719587321237', 1),
('Turtles', '8719587322245', 1),
('Witte Muizen', '8719587328256', 1),
('Reuzen Slangen', '8719587325641', 1),
('Zoute Rijen', '8719587322739', 1),
('Winegums', '8719587327527', 0),  -- IsActief = false
('Drop Munten', '8719587322345', 1),
('Kruis Drop', '8719587322265', 1),
('Zoute Ruitjes', '8719587323256', 1);

-- ============================================================
-- Insert Sample Data: Magazijn
-- ============================================================
INSERT INTO magazijns (ProductId, VerpakkingsEenheid, AantalAanwezig) VALUES
(1, 5.00, 453),
(2, 2.50, 400),
(3, 5.00, 1),
(4, 1.00, 800),
(5, 3.00, 234),
(6, 2.00, 345),
(7, 1.00, 795),
(8, 10.00, 233),
(9, 2.50, 123),
(10, 3.00, NULL),
(11, 2.00, 367),
(12, 1.00, 467),
(13, 5.00, 20);

-- ============================================================
-- Insert Sample Data: Allergeens
-- ============================================================
INSERT INTO allergeens (Naam, Omschrijving) VALUES
('Gluten', 'Dit product bevat gluten'),
('Gelatine', 'Dit product bevat gelatine'),
('AZO-Kleurstof', 'Dit product bevat AZO-kleurstoffen'),
('Lactose', 'Dit product bevat lactose'),
('Soja', 'Dit product bevat soja');

-- ============================================================
-- Insert Sample Data: ProductPerAllergeen
-- ============================================================
INSERT INTO product_per_allergeens (ProductId, AllergeenId) VALUES
(1, 2),
(1, 1),
(1, 3),
(3, 4),
(6, 5),
(9, 2),
(9, 5),
(10, 2),
(12, 4),
(13, 1),
(13, 4),
(13, 5);

-- ============================================================
-- Insert Sample Data: ProductPerLeverancier
-- ============================================================
INSERT INTO product_per_leveranciers (LeverancierId, ProductId, DatumLevering, Aantal, DatumEerstVolgendeLevering) VALUES
(1, 1, '2024-11-09', 23, '2024-11-16'),
(1, 1, '2024-11-18', 21, '2024-11-25'),
(1, 2, '2024-11-09', 12, '2024-11-16'),
(1, 3, '2024-11-10', 11, '2024-11-17'),
(2, 4, '2024-11-14', 16, '2024-11-21'),
(2, 4, '2024-11-21', 23, '2024-11-28'),
(2, 5, '2024-11-14', 45, '2024-11-21'),
(2, 6, '2024-11-14', 30, '2024-11-21'),
(3, 7, '2024-11-12', 12, '2024-11-19'),
(3, 7, '2024-11-19', 23, '2024-11-26'),
(3, 8, '2024-11-10', 12, '2024-11-17'),
(3, 9, '2024-11-11', 1, '2024-11-18'),
(4, 10, '2024-11-16', 24, '2024-11-30'),
(5, 11, '2024-11-10', 47, '2024-11-17'),
(5, 11, '2024-11-19', 60, '2024-11-26'),
(5, 12, '2024-11-11', 45, NULL),
(5, 13, '2024-11-12', 23, NULL);

-- ============================================================
-- End of Script
-- ============================================================
