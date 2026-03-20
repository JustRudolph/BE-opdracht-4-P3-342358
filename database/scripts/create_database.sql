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
DROP TABLE IF EXISTS contacts;

-- ============================================================
-- Table: contacts (Contacts)
-- ============================================================
CREATE TABLE contacts (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    Straat VARCHAR(100) NOT NULL,
    Huisnummer VARCHAR(10) NOT NULL,
    Postcode VARCHAR(10) NOT NULL,
    Stad VARCHAR(100) NOT NULL,
    IsActief TINYINT(1) DEFAULT 1,
    Opmerking VARCHAR(255) NULL,
    DatumAangemaakt DATETIME(6) DEFAULT CURRENT_TIMESTAMP(6),
    DatumGewijzigd DATETIME(6) DEFAULT CURRENT_TIMESTAMP(6) ON UPDATE CURRENT_TIMESTAMP(6)
);

-- ============================================================
-- Table: leveranciers (Suppliers)
-- ============================================================
CREATE TABLE leveranciers (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    Naam VARCHAR(100) NOT NULL,
    ContactPersoon VARCHAR(100) NOT NULL,
    LeverancierNummer VARCHAR(20) NOT NULL,
    Mobiel VARCHAR(20) NOT NULL,
    ContactId BIGINT UNSIGNED NULL,
    IsActief TINYINT(1) DEFAULT 1,
    Opmerking VARCHAR(255) NULL,
    DatumAangemaakt DATETIME(6) DEFAULT CURRENT_TIMESTAMP(6),
    DatumGewijzigd DATETIME(6) DEFAULT CURRENT_TIMESTAMP(6) ON UPDATE CURRENT_TIMESTAMP(6),
    FOREIGN KEY (ContactId) REFERENCES contacts(id) ON DELETE SET NULL
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
-- Insert Sample Data: Contacts
-- ============================================================
INSERT INTO contacts (Straat, Huisnummer, Postcode, Stad, IsActief) VALUES
('Van Gilslaan', '34', '1045CB', 'Hilvarenbeek', 1),
('Den Dolderpad', '2', '1067RC', 'Utrecht', 1),
('Fredo Raalteweg', '257', '1236OP', 'Nijmegen', 1),
('Bertrand Russellhof', '21', '2034AP', 'Den Haag', 1),
('Leon van Bonstraat', '213', '145XC', 'Lunteren', 1),
('Bea van Lingenlaan', '234', '2197FG', 'Sint Pancras', 1);

-- ============================================================
-- Insert Sample Data: Leveranciers
-- ============================================================
INSERT INTO leveranciers (Naam, ContactPersoon, LeverancierNummer, Mobiel, ContactId) VALUES
('Venco', 'Bert van Linge', 'L1029384719', '06-28493827', 1),
('Astra Sweets', 'Jasper del Monte', 'L1029284315', '06-39398734', 2),
('Haribo', 'Sven Stalman', 'L1029324748', '06-24383291', 3),
('Basset', 'Joyce Stelterberg', 'L1023845773', '06-48293823', 4),
('De Bron', 'Remco Veenstra', 'L1023857736', '06-34291234', 5),
('Quality Street', 'Johan Nooij', 'L1029234586', '06-23458456', 6),
('Hom Ken Food', 'Hom Ken', 'L1029234599', '06-23458477', NULL);

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
('Zoute Ruitjes', '8719587323256', 1),
('Drop ninja''s', '8719587323277', 1);

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
(13, 5.00, 20),
(14, 2.00, 150);

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
(13, 5),
(14, 5);

-- ============================================================
-- Insert Sample Data: ProductPerLeverancier
-- ============================================================
INSERT INTO product_per_leveranciers (LeverancierId, ProductId, DatumLevering, Aantal, DatumEerstVolgendeLevering) VALUES
(1, 1, '2023-04-09', 23, '2023-04-16'),
(1, 1, '2023-04-18', 21, '2023-04-25'),
(1, 2, '2023-04-09', 12, '2023-04-16'),
(1, 3, '2023-04-10', 11, '2023-04-17'),
(2, 4, '2023-04-14', 16, '2023-04-21'),
(2, 4, '2023-04-21', 23, '2023-04-28'),
(2, 5, '2023-04-14', 45, '2023-04-21'),
(2, 6, '2023-04-14', 30, '2023-04-21'),
(3, 7, '2023-04-12', 12, '2023-04-19'),
(3, 7, '2023-04-19', 23, '2023-04-26'),
(3, 8, '2023-04-10', 12, '2023-04-17'),
(3, 9, '2023-04-11', 1, '2023-04-18'),
(4, 10, '2023-04-16', 24, '2023-04-30'),
(5, 11, '2023-04-10', 47, '2023-04-17'),
(5, 11, '2023-04-19', 60, '2023-04-26'),
(5, 12, '2023-04-11', 45, NULL),
(5, 13, '2023-04-12', 23, NULL),
(7, 14, '2023-04-14', 20, NULL);

-- ============================================================
-- End of Script
-- ============================================================
