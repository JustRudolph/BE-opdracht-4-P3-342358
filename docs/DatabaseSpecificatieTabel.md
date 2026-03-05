# Database Specificatie Tabellen - User Story 01: Allergen Overview

## Overzicht
Dit document beschrijft alle databasetabellen gebruikt in User Story 01 (Allergen Overview). De tabellen bevatten allergeninformatie, producten en leveranciergegevens.

---

## Tabel: Products

| Kolom naam | Datatype | Lengte | Nullable | Opmerking |
|---|---|---|---|---|
| Id | BIGINT | - | Nee | PK, AUTO_INCREMENT |
| Naam | VARCHAR | 100 | Nee | Productnaam |
| Barcode | VARCHAR | 20 | Nee | EAN-barcode |
| IsActief | BIT | 1 | Nee | Systeemveld (0 = inactief, 1 = actief) |
| Opmerking | VARCHAR | 255 | Ja | Systeemveld |
| DatumAangemaakt | DATETIME | 6 | Nee | Systeemveld, DEFAULT CURRENT_TIMESTAMP |
| DatumGewijzigd | DATETIME | 6 | Nee | Systeemveld, AUTO_UPDATE |

**Relaties:**
- FK naar Magazijn (1:1)
- FK naar ProductPerAllergeen (1:N)
- FK naar ProductPerLeverancier (1:N)

---

## Tabel: Allergeens

| Kolom naam | Datatype | Lengte | Nullable | Opmerking |
|---|---|---|---|---|
| Id | BIGINT | - | Nee | PK, AUTO_INCREMENT |
| Naam | VARCHAR | 100 | Nee | Allergeen naam (Gluten, Soja, etc.) |
| Omschrijving | VARCHAR | 255 | Nee | Beschrijving van het allergeen |
| IsActief | BIT | 1 | Nee | Systeemveld |
| Opmerking | VARCHAR | 255 | Ja | Systeemveld |
| DatumAangemaakt | DATETIME | 6 | Nee | Systeemveld |
| DatumGewijzigd | DATETIME | 6 | Nee | Systeemveld |

**Relaties:**
- FK naar ProductPerAllergeen (1:N)

**Allergeens in testdata:**
1. Gluten
2. Gelatine
3. AZO-Kleurstof
4. Lactose
5. Soja

---

## Tabel: ProductPerAllergeens

| Kolom naam | Datatype | Lengte | Nullable | Opmerking |
|---|---|---|---|---|
| Id | BIGINT | - | Nee | PK, AUTO_INCREMENT |
| ProductId | BIGINT | - | Nee | FK naar Products |
| AllergeenId | BIGINT | - | Nee | FK naar Allergeens |
| IsActief | BIT | 1 | Nee | Systeemveld |
| Opmerking | VARCHAR | 255 | Ja | Systeemveld |
| DatumAangemaakt | DATETIME | 6 | Nee | Systeemveld |
| DatumGewijzigd | DATETIME | 6 | Nee | Systeemveld |

**Relaties:**
- FK ProductId naar Products (onDelete: CASCADE)
- FK AllergeenId naar Allergeens (onDelete: CASCADE)

**Relatietype:** Many-to-Many (Pivot tabel)

---

## Tabel: Leveranciers

| Kolom naam | Datatype | Lengte | Nullable | Opmerking |
|---|---|---|---|---|
| Id | BIGINT | - | Nee | PK, AUTO_INCREMENT |
| Naam | VARCHAR | 100 | Nee | Leveranciernaam |
| ContactPersoon | VARCHAR | 100 | Nee | Naam contactpersoon |
| LeverancierNummer | VARCHAR | 20 | Nee | Uniek leveranciernummer |
| Mobiel | VARCHAR | 20 | Nee | Telefoonnummer |
| ContactId | BIGINT | - | Ja | FK naar Contacts (nullable voor Scenario 03) |
| IsActief | BIT | 1 | Nee | Systeemveld |
| Opmerking | VARCHAR | 255 | Ja | Systeemveld |
| DatumAangemaakt | DATETIME | 6 | Nee | Systeemveld |
| DatumGewijzigd | DATETIME | 6 | Nee | Systeemveld |

**Relaties:**
- FK ContactId naar Contacts (onDelete: SET NULL)
- FK naar ProductPerLeverancier (1:N)

**Leveranciers in testdata:**
1. Venco (ContactId: 1)
2. Astra Sweets (ContactId: 2)
3. Haribo (ContactId: 3)
4. Basset (ContactId: 4)
5. De Bron (ContactId: 5)
6. Quality Street (ContactId: 6)
7. Hom Ken Food (ContactId: NULL) - Scenario 03

---

## Tabel: Contacts

| Kolom naam | Datatype | Lengte | Nullable | Opmerking |
|---|---|---|---|---|
| Id | BIGINT | - | Nee | PK, AUTO_INCREMENT |
| Straat | VARCHAR | 100 | Nee | Adresnaam |
| Huisnummer | INT | - | Nee | Huisnummer |
| Postcode | VARCHAR | 10 | Nee | Postcode |
| Stad | VARCHAR | 100 | Nee | Plaatsnaam |
| IsActief | BIT | 1 | Nee | Systeemveld |
| Opmerking | VARCHAR | 255 | Ja | Systeemveld |
| DatumAangemaakt | DATETIME | 6 | Nee | Systeemveld |
| DatumGewijzigd | DATETIME | 6 | Nee | Systeemveld |

**Relaties:**
- 1:N met Leveranciers

---

## Tabel: ProductPerLeveranciers

| Kolom naam | Datatype | Lengte | Nullable | Opmerking |
|---|---|---|---|---|
| Id | BIGINT | - | Nee | PK, AUTO_INCREMENT |
| LeverancierId | BIGINT | - | Nee | FK naar Leveranciers |
| ProductId | BIGINT | - | Nee | FK naar Products |
| DatumLevering | DATE | - | Nee | Leveringsdatum |
| Aantal | INT | - | Nee | Aantal geleverde eenheden |
| DatumEerstVolgendeLevering | DATE | - | Ja | Voorgestelde datum volgende levering |
| IsActief | BIT | 1 | Nee | Systeemveld |
| Opmerking | VARCHAR | 255 | Ja | Systeemveld |
| DatumAangemaakt | DATETIME | 6 | Nee | Systeemveld |
| DatumGewijzigd | DATETIME | 6 | Nee | Systeemveld |

**Relaties:**
- FK LeverancierId naar Leveranciers (onDelete: CASCADE)
- FK ProductId naar Products (onDelete: CASCADE)

**Relatietype:** Many-to-Many (Pivot tabel)

---

## Tabel: Magazijns

| Kolom naam | Datatype | Lengte | Nullable | Opmerking |
|---|---|---|---|---|
| Id | BIGINT | - | Nee | PK, AUTO_INCREMENT |
| ProductId | BIGINT | - | Nee | FK naar Products |
| VerpakkingsEenheid | DECIMAL | 8,2 | Nee | Gewicht/volume per eenheid |
| AantalAanwezig | INT | - | Ja | Actuele voorraadhoeveelheid |
| IsActief | BIT | 1 | Nee | Systeemveld |
| Opmerking | VARCHAR | 255 | Ja | Systeemveld |
| DatumAangemaakt | DATETIME | 6 | Nee | Systeemveld |
| DatumGewijzigd | DATETIME | 6 | Nee | Systeemveld |

**Relaties:**
- FK ProductId naar Products (onDelete: CASCADE)

---

## Indexen

| Tabel | Kolommen | Type | Opmerking |
|---|---|---|---|
| Products | Id | PRIMARY | |
| Allergeens | Id | PRIMARY | |
| ProductPerAllergeens | Id | PRIMARY | |
| ProductPerAllergeens | ProductId | FOREIGN KEY | |
| ProductPerAllergeens | AllergeenId | FOREIGN KEY | |
| Leveranciers | Id | PRIMARY | |
| Leveranciers | ContactId | FOREIGN KEY | |
| Contacts | Id | PRIMARY | |
| ProductPerLeveranciers | Id | PRIMARY | |
| ProductPerLeveranciers | LeverancierId | FOREIGN KEY | |
| ProductPerLeveranciers | ProductId | FOREIGN KEY | |
| Magazijns | Id | PRIMARY | |
| Magazijns | ProductId | FOREIGN KEY | |

---

## Data Integriteit

- **Cascade Delete:** Wanneer een Product verwijderd wordt, worden alle gerelateerde ProductPerAllergeen en ProductPerLeverancier records verwijderd
- **Set Null:** Wanneer een Contact verwijderd wordt, wordt de ContactId in Leveranciers op NULL gezet
- **System Fields:** Alle tabellen bevatten IsActief, Opmerking, DatumAangemaakt, DatumGewijzigd
- **Timestamps:** DatumGewijzigd wordt automatisch bijgewerkt bij elke wijziging

---

## Notities voor Implementatie

1. **Scenario 01**: Filter op ProductPerAllergeens.AllergeenId, join met Products en sort op Naam
2. **Scenario 02**: Join ProductPerLeveranciers met Leveranciers en Contacts, toon alle adresgegevens
3. **Scenario 03**: Join ProductPerLeveranciers met Leveranciers, check of Leveranciers.ContactId NULL is
4. **Pagination**: Implementeren op Products in allergeens.index view (4 items per pagina)
5. **Sorting**: Alle product-lijsten standaard sorteren op Naam (A-Z)
