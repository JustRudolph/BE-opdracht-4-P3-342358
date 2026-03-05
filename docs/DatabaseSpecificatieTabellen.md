# Database Specificatie Tabellen

## Leverancier
- Id: INT (PK), Nullable: Nee
- Naam: VARCHAR(100), Nee
- ContactPersoon: VARCHAR(100), Nee
- LeverancierNummer: VARCHAR(20), Nee
- Mobiel: VARCHAR(20), Nee
- ContactId: INT (FK → Contact), Ja
- IsActief: BIT(1), Nee
- Opmerking: VARCHAR(255), Ja
- DatumAangemaakt: DATETIME(6), Nee
- DatumGewijzigd: DATETIME(6), Nee

## Contact
- Id: INT (PK), Nee
- Straat: VARCHAR(100), Nee
- Huisnummer: INT, Nee
- Postcode: VARCHAR(10), Nee
- Stad: VARCHAR(100), Nee
- IsActief: BIT(1), Nee
- Opmerking: VARCHAR(255), Ja
- DatumAangemaakt: DATETIME(6), Nee
- DatumGewijzigd: DATETIME(6), Nee

## Product
- Id: INT (PK), Nee
- Naam: VARCHAR(100), Nee
- Barcode: VARCHAR(20), Nee
- IsActief: BIT(1), Nee
- Opmerking: VARCHAR(255), Ja
- DatumAangemaakt: DATETIME(6), Nee
- DatumGewijzigd: DATETIME(6), Nee

## Magazijn
- Id: INT (PK), Nee
- ProductId: INT (FK → Product), Nee
- VerpakkingsEenheid: DECIMAL(8,2), Nee
- AantalAanwezig: INT, Ja
- IsActief: BIT(1), Nee
- Opmerking: VARCHAR(255), Ja
- DatumAangemaakt: DATETIME(6), Nee
- DatumGewijzigd: DATETIME(6), Nee

## Allergeen
- Id: INT (PK), Nee
- Naam: VARCHAR(100), Nee
- Omschrijving: VARCHAR(255), Nee
- IsActief: BIT(1), Nee
- Opmerking: VARCHAR(255), Ja
- DatumAangemaakt: DATETIME(6), Nee
- DatumGewijzigd: DATETIME(6), Nee

## ProductPerAllergeen
- Id: INT (PK), Nee
- ProductId: INT (FK → Product), Nee
- AllergeenId: INT (FK → Allergeen), Nee
- IsActief: BIT(1), Nee
- Opmerking: VARCHAR(255), Ja
- DatumAangemaakt: DATETIME(6), Nee
- DatumGewijzigd: DATETIME(6), Nee

## ProductPerLeverancier
- Id: INT (PK), Nee
- LeverancierId: INT (FK → Leverancier), Nee
- ProductId: INT (FK → Product), Nee
- DatumLevering: DATE, Nee
- Aantal: INT, Nee
- DatumEerstVolgendeLevering: DATE, Ja
- IsActief: BIT(1), Nee
- Opmerking: VARCHAR(255), Ja
- DatumAangemaakt: DATETIME(6), Nee
- DatumGewijzigd: DATETIME(6), Nee
