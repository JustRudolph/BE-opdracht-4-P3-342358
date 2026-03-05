-- Stored Procedures for User Story 1

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
