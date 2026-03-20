-- ============================================================
-- Stored Procedures for "Overzicht geleverde producten"
-- User Story 01
-- ============================================================

-- ============================================================
-- Procedure: sp_GetDeliveredProductsByDateRange
-- Description: Gets all delivered products within a date range,
-- sorted by supplier name (A-Z) and showing total quantity per product
-- Parameters:
--   IN p_StartDate: Start date of the range (DATE)
--   IN p_EndDate: End date of the range (DATE)
-- ============================================================
DELIMITER //

DROP PROCEDURE IF EXISTS sp_GetDeliveredProductsByDateRange //

CREATE PROCEDURE sp_GetDeliveredProductsByDateRange(
    IN p_StartDate DATE,
    IN p_EndDate DATE
)
BEGIN
    SELECT 
        ppl.ProductId,
        p.Naam AS ProductNaam,
        p.Barcode,
        l.Naam AS LeverancierNaam,
        l.ContactPersoon,
        l.Mobiel,
        SUM(ppl.Aantal) AS TotalAantalGeleverd,
        COUNT(DISTINCT ppl.DatumLevering) AS AantalLeveringen,
        MIN(ppl.DatumLevering) AS EersteLeveringDatum,
        MAX(ppl.DatumLevering) AS LaasteLeveringDatum
    FROM 
        product_per_leveranciers ppl
    INNER JOIN 
        products p ON ppl.ProductId = p.id
    INNER JOIN 
        leveranciers l ON ppl.LeverancierId = l.id
    WHERE 
        ppl.DatumLevering BETWEEN p_StartDate AND p_EndDate
        AND ppl.IsActief = 1
        AND p.IsActief = 1
    GROUP BY 
        ppl.ProductId,
        p.Naam,
        p.Barcode,
        l.Naam,
        l.ContactPersoon,
        l.Mobiel
    ORDER BY 
        l.Naam ASC,
        p.Naam ASC;
END //

DELIMITER ;

-- ============================================================
-- Procedure: sp_GetProductDeliverySpecifications
-- Description: Gets detailed delivery information for a specific product
-- within a date range, including delivery dates and quantities
-- Parameters:
--   IN p_ProductId: Product ID (BIGINT UNSIGNED)
--   IN p_StartDate: Start date of the range (DATE)
--   IN p_EndDate: End date of the range (DATE)
-- ============================================================
DELIMITER //

DROP PROCEDURE IF EXISTS sp_GetProductDeliverySpecifications //

CREATE PROCEDURE sp_GetProductDeliverySpecifications(
    IN p_ProductId BIGINT UNSIGNED,
    IN p_StartDate DATE,
    IN p_EndDate DATE
)
BEGIN
    SELECT 
        ppl.id,
        ppl.DatumLevering,
        ppl.Aantal,
        l.Naam AS LeverancierNaam,
        l.ContactPersoon,
        l.LeverancierNummer,
        l.Mobiel,
        p.Naam AS ProductNaam,
        p.Barcode,
        ppl.DatumEerstVolgendeLevering
    FROM 
        product_per_leveranciers ppl
    INNER JOIN 
        products p ON ppl.ProductId = p.id
    INNER JOIN 
        leveranciers l ON ppl.LeverancierId = l.id
    WHERE 
        ppl.ProductId = p_ProductId
        AND ppl.DatumLevering BETWEEN p_StartDate AND p_EndDate
        AND ppl.IsActief = 1
        AND p.IsActief = 1
    ORDER BY 
        ppl.DatumLevering ASC;
END //

DELIMITER ;

-- ============================================================
-- Procedure: sp_CountDeliveredProductsByDateRange
-- Description: Counts the number of delivered products within a date range
-- Parameters:
--   IN p_StartDate: Start date of the range (DATE)
--   IN p_EndDate: End date of the range (DATE)
-- Returns: Total count of delivered products
-- ============================================================
DELIMITER //

DROP PROCEDURE IF EXISTS sp_CountDeliveredProductsByDateRange //

CREATE PROCEDURE sp_CountDeliveredProductsByDateRange(
    IN p_StartDate DATE,
    IN p_EndDate DATE,
    OUT p_Count INT
)
BEGIN
    SELECT COUNT(DISTINCT ppl.ProductId) INTO p_Count
    FROM 
        product_per_leveranciers ppl
    INNER JOIN 
        products p ON ppl.ProductId = p.id
    WHERE 
        ppl.DatumLevering BETWEEN p_StartDate AND p_EndDate
        AND ppl.IsActief = 1
        AND p.IsActief = 1;
END //

DELIMITER ;

-- ============================================================
-- End of Stored Procedures
-- ============================================================
