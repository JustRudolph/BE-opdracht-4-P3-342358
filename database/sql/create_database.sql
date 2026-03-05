-- ============================================
-- Jamin Database Export
-- Opdracht 2 - BE-2024-P2-WK1-IO-SD-2309AB
-- ============================================

-- Create Leveranciers Table
CREATE TABLE IF NOT EXISTS `leveranciers` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `Naam` varchar(100) NOT NULL,
  `ContactPersoon` varchar(100) NOT NULL,
  `LeverancierNummer` varchar(20) NOT NULL,
  `Mobiel` varchar(20) NOT NULL,
  `ContactId` bigint(20) unsigned DEFAULT NULL,
  `IsActief` tinyint(1) NOT NULL DEFAULT 1,
  `Opmerking` varchar(255) DEFAULT NULL,
  `DatumAangemaakt` datetime(6) NOT NULL DEFAULT CURRENT_TIMESTAMP(6),
  `DatumGewijzigd` datetime(6) NOT NULL DEFAULT CURRENT_TIMESTAMP(6) ON UPDATE CURRENT_TIMESTAMP(6),
  PRIMARY KEY (`id`),
  KEY `leveranciers_contactid_foreign` (`ContactId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Create Contacts Table
CREATE TABLE IF NOT EXISTS `contacts` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `Straat` varchar(100) NOT NULL,
  `Huisnummer` int(11) NOT NULL,
  `Postcode` varchar(10) NOT NULL,
  `Stad` varchar(100) NOT NULL,
  `IsActief` tinyint(1) NOT NULL DEFAULT 1,
  `Opmerking` varchar(255) DEFAULT NULL,
  `DatumAangemaakt` datetime(6) NOT NULL DEFAULT CURRENT_TIMESTAMP(6),
  `DatumGewijzigd` datetime(6) NOT NULL DEFAULT CURRENT_TIMESTAMP(6) ON UPDATE CURRENT_TIMESTAMP(6),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Create Products Table
CREATE TABLE IF NOT EXISTS `products` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `Naam` varchar(100) NOT NULL,
  `Barcode` varchar(20) NOT NULL,
  `IsActief` tinyint(1) NOT NULL DEFAULT 1,
  `Opmerking` varchar(255) DEFAULT NULL,
  `DatumAangemaakt` datetime(6) NOT NULL DEFAULT CURRENT_TIMESTAMP(6),
  `DatumGewijzigd` datetime(6) NOT NULL DEFAULT CURRENT_TIMESTAMP(6) ON UPDATE CURRENT_TIMESTAMP(6),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Create Magazijns Table
CREATE TABLE IF NOT EXISTS `magazijns` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `ProductId` bigint(20) unsigned NOT NULL,
  `VerpakkingsEenheid` decimal(8,2) NOT NULL,
  `AantalAanwezig` int(11) DEFAULT NULL,
  `IsActief` tinyint(1) NOT NULL DEFAULT 1,
  `Opmerking` varchar(255) DEFAULT NULL,
  `DatumAangemaakt` datetime(6) NOT NULL DEFAULT CURRENT_TIMESTAMP(6),
  `DatumGewijzigd` datetime(6) NOT NULL DEFAULT CURRENT_TIMESTAMP(6) ON UPDATE CURRENT_TIMESTAMP(6),
  PRIMARY KEY (`id`),
  KEY `magazijns_productid_foreign` (`ProductId`),
  CONSTRAINT `magazijns_productid_foreign` FOREIGN KEY (`ProductId`) REFERENCES `products` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Create Allergeens Table
CREATE TABLE IF NOT EXISTS `allergeens` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `Naam` varchar(100) NOT NULL,
  `Omschrijving` varchar(255) NOT NULL,
  `IsActief` tinyint(1) NOT NULL DEFAULT 1,
  `Opmerking` varchar(255) DEFAULT NULL,
  `DatumAangemaakt` datetime(6) NOT NULL DEFAULT CURRENT_TIMESTAMP(6),
  `DatumGewijzigd` datetime(6) NOT NULL DEFAULT CURRENT_TIMESTAMP(6) ON UPDATE CURRENT_TIMESTAMP(6),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Create ProductPerAllergeens Table
CREATE TABLE IF NOT EXISTS `product_per_allergeens` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `ProductId` bigint(20) unsigned NOT NULL,
  `AllergeenId` bigint(20) unsigned NOT NULL,
  `IsActief` tinyint(1) NOT NULL DEFAULT 1,
  `Opmerking` varchar(255) DEFAULT NULL,
  `DatumAangemaakt` datetime(6) NOT NULL DEFAULT CURRENT_TIMESTAMP(6),
  `DatumGewijzigd` datetime(6) NOT NULL DEFAULT CURRENT_TIMESTAMP(6) ON UPDATE CURRENT_TIMESTAMP(6),
  PRIMARY KEY (`id`),
  KEY `product_per_allergeens_productid_foreign` (`ProductId`),
  KEY `product_per_allergeens_allergeenid_foreign` (`AllergeenId`),
  CONSTRAINT `product_per_allergeens_productid_foreign` FOREIGN KEY (`ProductId`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  CONSTRAINT `product_per_allergeens_allergeenid_foreign` FOREIGN KEY (`AllergeenId`) REFERENCES `allergeens` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Create ProductPerLeveranciers Table
CREATE TABLE IF NOT EXISTS `product_per_leveranciers` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `LeverancierId` bigint(20) unsigned NOT NULL,
  `ProductId` bigint(20) unsigned NOT NULL,
  `DatumLevering` date NOT NULL,
  `Aantal` int(11) NOT NULL,
  `DatumEerstVolgendeLevering` date DEFAULT NULL,
  `IsActief` tinyint(1) NOT NULL DEFAULT 1,
  `Opmerking` varchar(255) DEFAULT NULL,
  `DatumAangemaakt` datetime(6) NOT NULL DEFAULT CURRENT_TIMESTAMP(6),
  `DatumGewijzigd` datetime(6) NOT NULL DEFAULT CURRENT_TIMESTAMP(6) ON UPDATE CURRENT_TIMESTAMP(6),
  PRIMARY KEY (`id`),
  KEY `product_per_leveranciers_leverancierid_foreign` (`LeverancierId`),
  KEY `product_per_leveranciers_productid_foreign` (`ProductId`),
  CONSTRAINT `product_per_leveranciers_leverancierid_foreign` FOREIGN KEY (`LeverancierId`) REFERENCES `leveranciers` (`id`) ON DELETE CASCADE,
  CONSTRAINT `product_per_leveranciers_productid_foreign` FOREIGN KEY (`ProductId`) REFERENCES `products` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Insert Leveranciers
-- Insert Contacts
INSERT INTO `contacts` (`id`, `Straat`, `Huisnummer`, `Postcode`, `Stad`, `IsActief`, `Opmerking`) VALUES
(1, 'Van Gilslaan', 34, '1045CB', 'Hilvarenbeek', 1, NULL),
(2, 'Den Dolderpad', 2, '1067RC', 'Utrecht', 1, NULL),
(3, 'Fredo Raalteweg', 257, '1236OP', 'Nijmegen', 1, NULL),
(4, 'Bertrand Russellhof', 21, '2034AP', 'Den Haag', 1, NULL),
(5, 'Leon van Bonstraat', 213, '145XC', 'Lunteren', 1, NULL),
(6, 'Bea van Lingenlaan', 234, '2197FG', 'Sint Pancras', 1, NULL);

-- Insert Leveranciers with ContactId
INSERT INTO `leveranciers` (`id`, `Naam`, `ContactPersoon`, `LeverancierNummer`, `Mobiel`, `ContactId`, `IsActief`, `Opmerking`) VALUES
(1, 'Venco', 'Bert van Linge', 'L1029384719', '06-28493827', 1, 1, NULL),
(2, 'Astra Sweets', 'Jasper del Monte', 'L1029284315', '06-39398734', 2, 1, NULL),
(3, 'Haribo', 'Sven Stalman', 'L1029324748', '06-24383291', 3, 1, NULL),
(4, 'Basset', 'Joyce Stelterberg', 'L1023845773', '06-48293823', 4, 1, NULL),
(5, 'De Bron', 'Remco Veenstra', 'L1023857736', '06-34291234', 5, 1, NULL),
(6, 'Quality Street', 'Johan Nooij', 'L1029234586', '06-23458456', 6, 1, NULL),
(7, 'Hom Ken Food', 'Hom Ken', 'L1029234599', '06-23458477', NULL, 1, NULL);

-- Insert Products
INSERT INTO `products` (`id`, `Naam`, `Barcode`, `IsActief`, `Opmerking`) VALUES
(1, 'Mintnopjes', '8719587231278', 1, NULL),
(2, 'Schoolkrijt', '8719587326713', 1, NULL),
(3, 'Honingdrop', '8719587327836', 1, NULL),
(4, 'Zure Beren', '8719587321441', 1, NULL),
(5, 'Cola Flesjes', '8719587321237', 1, NULL),
(6, 'Turtles', '8719587322245', 1, NULL),
(7, 'Witte Muizen', '8719587328256', 1, NULL),
(8, 'Reuzen Slangen', '8719587325641', 1, NULL),
(9, 'Zoute Rijen', '8719587322739', 1, NULL),
(10, 'Winegums', '8719587327527', 0, NULL),
(11, 'Drop Munten', '8719587322345', 1, NULL),
(12, 'Kruis Drop', '8719587322265', 1, NULL),
(13, 'Zoute Ruitjes', '8719587323256', 1, NULL),
(14, 'Drop Ninja''s', '8719587323277', 1, NULL);

-- Insert Magazijns
INSERT INTO `magazijns` (`id`, `ProductId`, `VerpakkingsEenheid`, `AantalAanwezig`, `IsActief`, `Opmerking`) VALUES
(1, 1, 5.00, 453, 1, NULL),
(2, 2, 2.50, 400, 1, NULL),
(3, 3, 5.00, 1, 1, NULL),
(4, 4, 1.00, 800, 1, NULL),
(5, 5, 3.00, 234, 1, NULL),
(6, 6, 2.00, 345, 1, NULL),
(7, 7, 1.00, 795, 1, NULL),
(8, 8, 10.00, 233, 1, NULL),
(9, 9, 2.50, 123, 1, NULL),
(10, 10, 3.00, NULL, 1, NULL),
(11, 11, 2.00, 367, 1, NULL),
(12, 12, 1.00, 467, 1, NULL),
(13, 13, 5.00, 20, 1, NULL),
(14, 14, 10.00, 150, 1, NULL);

-- Insert Allergeens
INSERT INTO `allergeens` (`id`, `Naam`, `Omschrijving`, `IsActief`, `Opmerking`) VALUES
(1, 'Gluten', 'Dit product bevat gluten', 1, NULL),
(2, 'Gelatine', 'Dit product bevat gelatine', 1, NULL),
(3, 'AZO-Kleurstof', 'Dit product bevat AZO-kleurstoffen', 1, NULL),
(4, 'Lactose', 'Dit product bevat lactose', 1, NULL),
(5, 'Soja', 'Dit product bevat soja', 1, NULL);

-- Insert ProductPerAllergeens
INSERT INTO `product_per_allergeens` (`id`, `ProductId`, `AllergeenId`, `IsActief`, `Opmerking`) VALUES
(1, 1, 2, 1, NULL),
(2, 1, 1, 1, NULL),
(3, 1, 3, 1, NULL),
(4, 3, 4, 1, NULL),
(5, 6, 5, 1, NULL),
(6, 9, 2, 1, NULL),
(7, 9, 5, 1, NULL),
(8, 10, 2, 1, NULL),
(9, 12, 4, 1, NULL),
(10, 13, 1, 1, NULL),
(11, 13, 4, 1, NULL),
(12, 13, 5, 1, NULL),
(13, 14, 5, 1, NULL);

-- Insert ProductPerLeveranciers
INSERT INTO `product_per_leveranciers` (`id`, `LeverancierId`, `ProductId`, `DatumLevering`, `Aantal`, `DatumEerstVolgendeLevering`, `IsActief`, `Opmerking`) VALUES
(1, 1, 1, '2024-11-09', 23, '2024-11-16', 1, NULL),
(2, 1, 1, '2024-11-18', 21, '2024-11-25', 1, NULL),
(3, 1, 2, '2024-11-09', 12, '2024-11-16', 1, NULL),
(4, 1, 3, '2024-11-10', 11, '2024-11-17', 1, NULL),
(5, 2, 4, '2024-11-14', 16, '2024-11-21', 1, NULL),
(6, 2, 4, '2024-11-21', 23, '2024-11-28', 1, NULL),
(7, 2, 5, '2024-11-14', 45, '2024-11-21', 1, NULL),
(8, 2, 6, '2024-11-14', 30, '2024-11-21', 1, NULL),
(9, 3, 7, '2024-11-12', 12, '2024-11-19', 1, NULL),
(10, 3, 7, '2024-11-19', 23, '2024-11-26', 1, NULL),
(11, 3, 8, '2024-11-10', 12, '2024-11-17', 1, NULL),
(12, 3, 9, '2024-11-11', 1, '2024-11-18', 1, NULL),
(13, 4, 10, '2024-11-16', 24, '2024-11-30', 1, NULL),
(14, 5, 11, '2024-11-10', 47, '2024-11-17', 1, NULL),
(15, 5, 11, '2024-11-19', 60, '2024-11-26', 1, NULL),
(16, 5, 12, '2024-11-11', 45, NULL, 1, NULL),
(17, 5, 13, '2024-11-12', 23, NULL, 1, NULL),
(18, 7, 14, '2024-11-14', 20, NULL, 1, NULL);

-- Add FK from leveranciers to contacts (after both tables exist)
ALTER TABLE `leveranciers`
  ADD CONSTRAINT `leveranciers_contactid_foreign`
  FOREIGN KEY (`ContactId`) REFERENCES `contacts` (`id`) ON DELETE SET NULL;
