-- Stored Procedures for User Story 1 - Allergen Overview
-- ============================================

DELIMITER //

-- Procedure: GetProductsWithAllergens
-- Purpose: Retrieve all products that contain specific allergens, sorted by product name (A-Z)
-- Parameters: 
--   @AllergeenId INT - The allergen ID to filter by (0 = all allergens)

DROP PROCEDURE IF EXISTS GetProductsWithAllergens//

CREATE PROCEDURE GetProductsWithAllergens(
    IN p_allergen_id INT
)
BEGIN
    DECLARE EXIT HANDLER FOR SQLEXCEPTION
    BEGIN
        GET DIAGNOSTICS CONDITION 1
            @error_code = RETURNED_SQLSTATE,
            @error_msg = MESSAGE_TEXT;
        SELECT CONCAT('Error: ', @error_code, ' - ', @error_msg) AS ErrorMessage;
    END;

    IF p_allergen_id = 0 OR p_allergen_id IS NULL THEN
        -- Return all products with any allergen
        SELECT DISTINCT
            p.id,
            p.Naam,
            p.Barcode,
            p.IsActief,
            m.AantalAanwezig,
            GROUP_CONCAT(DISTINCT a.Naam SEPARATOR ', ') as Allergeens
        FROM products p
        INNER JOIN product_per_allergeens ppa ON p.id = ppa.ProductId
        INNER JOIN allergeens a ON ppa.AllergeenId = a.id
        INNER JOIN magazijns m ON p.id = m.ProductId
        WHERE p.IsActief = 1 AND ppa.IsActief = 1 AND a.IsActief = 1
        GROUP BY p.id, p.Naam, p.Barcode, p.IsActief, m.AantalAanwezig
        ORDER BY p.Naam ASC;
    ELSE
        -- Return products with specific allergen
        SELECT DISTINCT
            p.id,
            p.Naam,
            p.Barcode,
            p.IsActief,
            m.AantalAanwezig,
            GROUP_CONCAT(DISTINCT a.Naam SEPARATOR ', ') as Allergeens
        FROM products p
        INNER JOIN product_per_allergeens ppa ON p.id = ppa.ProductId
        INNER JOIN allergeens a ON ppa.AllergeenId = a.id
        INNER JOIN magazijns m ON p.id = m.ProductId
        WHERE ppa.AllergeenId = p_allergen_id
          AND p.IsActief = 1
          AND ppa.IsActief = 1
          AND a.IsActief = 1
        GROUP BY p.id, p.Naam, p.Barcode, p.IsActief, m.AantalAanwezig
        ORDER BY p.Naam ASC;
    END IF;
END //

-- Procedure: GetSupplierDetails
-- Purpose: Retrieve supplier information for a specific product
-- Parameters: 
--   @ProductId INT - The product ID

DROP PROCEDURE IF EXISTS GetSupplierDetails//

CREATE PROCEDURE GetSupplierDetails(
    IN p_product_id INT
)
BEGIN
    DECLARE EXIT HANDLER FOR SQLEXCEPTION
    BEGIN
        GET DIAGNOSTICS CONDITION 1
            @error_code = RETURNED_SQLSTATE,
            @error_msg = MESSAGE_TEXT;
        SELECT CONCAT('Error: ', @error_code, ' - ', @error_msg) AS ErrorMessage;
    END;

    SELECT
        l.id,
        l.Naam,
        l.ContactPersoon,
        l.LeverancierNummer,
        l.Mobiel,
        CASE WHEN c.id IS NULL THEN 0 ELSE 1 END as HasContactInfo,
        COALESCE(c.Straat, '') as Straat,
        COALESCE(c.Huisnummer, 0) as Huisnummer,
        COALESCE(c.Postcode, '') as Postcode,
        COALESCE(c.Stad, '') as Stad
    FROM products p
    INNER JOIN product_per_leveranciers ppl ON p.id = ppl.ProductId
    INNER JOIN leveranciers l ON ppl.LeverancierId = l.id
    LEFT JOIN contacts c ON l.ContactId = c.id
    WHERE p.id = p_product_id 
      AND p.IsActief = 1
      AND ppl.IsActief = 1
      AND l.IsActief = 1
    LIMIT 1;
END //

-- Procedure: GetAllergensForProduct
-- Purpose: Get all allergens contained in a specific product
-- Parameters: 
--   @ProductId INT - The product ID

DROP PROCEDURE IF EXISTS GetAllergensForProduct//

CREATE PROCEDURE GetAllergensForProduct(
    IN p_product_id INT
)
BEGIN
    DECLARE EXIT HANDLER FOR SQLEXCEPTION
    BEGIN
        GET DIAGNOSTICS CONDITION 1
            @error_code = RETURNED_SQLSTATE,
            @error_msg = MESSAGE_TEXT;
        SELECT CONCAT('Error: ', @error_code, ' - ', @error_msg) AS ErrorMessage;
    END;

    SELECT DISTINCT
        a.id,
        a.Naam,
        a.Omschrijving
    FROM allergeens a
    INNER JOIN product_per_allergeens ppa ON a.id = ppa.AllergeenId
    WHERE ppa.ProductId = p_product_id
      AND a.IsActief = 1
      AND ppa.IsActief = 1
    ORDER BY a.Naam ASC;
END //

DELIMITER ;

-- ============================================
-- Existing Procedures (unchanged)

DELIMITER $$

DROP PROCEDURE IF EXISTS sp_get_leverancier_details $$
CREATE PROCEDURE sp_get_leverancier_details(IN p_id BIGINT)
BEGIN
    SELECT l.id,
           l.Naam,
           l.ContactPersoon,
           l.LeverancierNummer,
           l.Mobiel,
           c.Straat,
           c.Huisnummer,
           c.Postcode,
           c.Stad
    FROM leveranciers l
    LEFT JOIN contacts c ON c.id = l.ContactId
    WHERE l.id = p_id;
END $$

DROP PROCEDURE IF EXISTS sp_update_leverancier_contact $$
CREATE PROCEDURE sp_update_leverancier_contact(
    IN p_leverancier_id BIGINT,
    IN p_mobiel VARCHAR(20),
    IN p_straat VARCHAR(100)
)
BEGIN
    DECLARE v_is_blocked BOOLEAN DEFAULT FALSE;

    -- Block updating for supplier 'De Bron' (id=5) per Scenario_02
    IF EXISTS (SELECT 1 FROM leveranciers WHERE id = p_leverancier_id AND (Naam = 'De Bron' OR id = 5)) THEN
        SET v_is_blocked = TRUE;
    END IF;

    IF v_is_blocked THEN
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Technical error: update blocked for test scenario';
    END IF;

    UPDATE leveranciers
       SET Mobiel = p_mobiel,
           DatumGewijzigd = NOW(6)
     WHERE id = p_leverancier_id;

    UPDATE contacts c
       JOIN leveranciers l ON l.ContactId = c.id
       SET c.Straat = p_straat,
           c.DatumGewijzigd = NOW(6)
     WHERE l.id = p_leverancier_id;
END $$

DROP PROCEDURE IF EXISTS sp_get_leveranciers_paginated $$
CREATE PROCEDURE sp_get_leveranciers_paginated(IN p_limit INT, IN p_offset INT)
BEGIN
    SELECT l.id,
           l.Naam,
           l.ContactPersoon,
           l.LeverancierNummer,
           l.Mobiel,
           COUNT(DISTINCT ppl.ProductId) AS AantalVerschillendeProducten
    FROM leveranciers l
    LEFT JOIN product_per_leveranciers ppl ON l.id = ppl.LeverancierId
    GROUP BY l.id, l.Naam, l.ContactPersoon, l.LeverancierNummer, l.Mobiel
    ORDER BY AantalVerschillendeProducten DESC
    LIMIT p_limit OFFSET p_offset;
END $$

DELIMITER ;
