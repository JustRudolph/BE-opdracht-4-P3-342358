# Testplan - User Story 01: Allergen Overview

**Project:** Jamin Manager\
**Opdracht:** BE-opdracht 04 - User Story 01\
**Testeer:** Allergen Overview functionality\
**Datum:** 5 maart 2026\
**Getest door:** Student\

---

## 1. Inleiding

Dit testplan beschrijft alle tests voor User Story 01: Allergen Overview. De feature stelt managers in staat om producten met allergenen in te zien en leveranciersinformatie op te vragen.

---

## 2. Test Omgeving

- **Server:** PHP Laravel Framework
- **Database:** MySQL 8.0+
- **Browser:** Chrome/Firefox (testversie)
- **Testdata:** SQL-bestand met 13 producten en 7 leveranciers
- **Test Framework:** PHPUnit + Laravel Testing

---

## 3. Test Coverage

### 3.1 Scenario 01: Filteren op Allergenen

**Testobject:** AllergeenController::index() + allergeens.index view\
**Vereisten:**
- Manager is ingelogd
- Kan allergenfilter selecteren
- Kan selectieknop gebruiken
- Producten sorteren A-Z op naam

| Test ID | Testcase | Input | Verwacht Resultaat | Status |
|---|---|---|---|---|
| TC-01-01 | Homepage link naar Overzicht | Klik "Overzicht Allergenen" | Allergen overview pagina laadt | ☐ Pass ☐ Fail |
| TC-01-02 | Alle allergeens in dropdown | Page load allergens.index | Dropdown toont 5 allergeens | ☐ Pass ☐ Fail |
| TC-01-03 | Filter op Lactose | Select "Lactose" + click "Maak selectie" | Toon alleen producten met Lactose | ☐ Pass ☐ Fail |
| TC-01-04 | Filter op Soja | Select "Soja" + click "Maak selectie" | Toon alleen producten met Soja | ☐ Pass ☐ Fail |
| TC-01-05 | Sortering A-Z | View any filtered results | Producten alfabetisch gesorteerd | ☐ Pass ☐ Fail |
| TC-01-06 | Paginatie weergave | Gefilterde resultaten | Max 4 producten per pagina | ☐ Pass ☐ Fail |
| TC-01-07 | Paginatie navigatie | Klik pagina 2 | Volgende 4 producten tonen | ☐ Pass ☐ Fail |
| TC-01-08 | Kolom headers | View table | Headers: Naam Product, Naam Allergeen, Omschrijving, Aantal Aanwezig, Info | ☐ Pass ☐ Fail |

---

### 3.2 Scenario 02: Leverancier Gegevens met Adres

**Testobject:** AllergeenController::supplierDetails() - with contact info\
**Vereisten:**
- Product met leverancier die adres heeft
- Alle adresvelden tonen

| Test ID | Testcase | Input | Verwacht Resultaat | Status |
|---|---|---|---|---|
| TC-02-01 | Leverancier info knop | Filter Lactose, klik info ? op Kruis Drop | Pagina "Overzicht Leverancier Gegevens" laadt | ☐ Pass ☐ Fail |
| TC-02-02 | Leverancier naam | View supplier details | Leveranciernaam zichtbaar (bijv. "De Bron") | ☐ Pass ☐ Fail |
| TC-02-03 | Contactpersoon | View supplier details | Contactpersoon getoond (bijv. "Remco Veenstra") | ☐ Pass ☐ Fail |
| TC-02-04 | Mobiel | View supplier details | Mobiel nummer getoond (bijv. "06-34291234") | ☐ Pass ☐ Fail |
| TC-02-05 | Leverancier nummer | View supplier details | L-nummer getoond | ☐ Pass ☐ Fail |
| TC-02-06 | Adresgegevens sectie | View supplier details | "Adresgegevens" sectie zichtbaar | ☐ Pass ☐ Fail |
| TC-02-07 | Straatnaam | View supplier details | Straatnaam correct (Leon van Bonstraat) | ☐ Pass ☐ Fail |
| TC-02-08 | Huisnummer | View supplier details | Huisnummer correct (213) | ☐ Pass ☐ Fail |
| TC-02-09 | Postcode | View supplier details | Postcode correct (145XC) | ☐ Pass ☐ Fail |
| TC-02-10 | Stad | View supplier details | Stad correct (Lunteren) | ☐ Pass ☐ Fail |
| TC-02-11 | Terug link | Click "Terug naar Overzicht" | Terug naar allergen overview | ☐ Pass ☐ Fail |

---

### 3.3 Scenario 03: Leverancier zonder Adres

**Testobject:** AllergeenController::supplierDetails() - without contact info\
**Vereisten:**
- Product met leverancier zonder adres (ContactId = NULL)
- Waarschuwing tonen

| Test ID | Testcase | Input | Verwacht Resultaat | Status |
|---|---|---|---|---|
| TC-03-01 | Filter Soja | Select "Soja" + click "Maak selectie" | Toon producten met Soja | ☐ Pass ☐ Fail |
| TC-03-02 | Drop Ninja's zichtbaar | View Soja filter | "Drop Ninja's" in de tabel | ☐ Pass ☐ Fail |
| TC-03-03 | Info knop Drop Ninja's | Click info ? op Drop Ninja's | Leverancier pagina laadt | ☐ Pass ☐ Fail |
| TC-03-04 | Leverancier naam | View supplier details | "Hom Ken Food" zichtbaar | ☐ Pass ☐ Fail |
| TC-03-05 | Geen adresgegevens melding | View supplier details | Waarschuwing: "Er zijn geen adresgegevens bekend" | ☐ Pass ☐ Fail |
| TC-03-06 | Geen adressectie | View supplier details | "Adresgegevens" sectie NIET zichtbaar | ☐ Pass ☐ Fail |
| TC-03-07 | Contactpersoon | View supplier details | "Hom Ken" zichtbaar | ☐ Pass ☐ Fail |
| TC-03-08 | Mobiel | View supplier details | "06-23458477" zichtbaar | ☐ Pass ☐ Fail |

---

### 3.4 Functionaliteit Tests

| Test ID | Testcase | Input | Verwacht Resultaat | Status |
|---|---|---|---|---|
| TC-04-01 | Reset filter | Select "-- Alle allergenen --" | Toon alle producten met allergeens | ☐ Pass ☐ Fail |
| TC-04-02 | Geen resultaten validatie | Filter op allergen met 0 match | "Geen producten met allergenen gevonden" | ☐ Pass ☐ Fail |
| TC-04-03 | Allergen info in tabel | View product row | Omschrijving van allergen zichtbaar | ☐ Pass ☐ Fail |
| TC-04-04 | Aantal aanwezig | View product row | Aantal uit Magazijn tabel getoond | ☐ Pass ☐ Fail |
| TC-04-05 | Invalid product ID | Direct URL /allergeens/999/supplier-details | 404 Error getoond | ☐ Pass ☐ Fail |
| TC-04-06 | Inactieve producten filter | Set Product.IsActief=0 | Inactieve producten niet getoond | ☐ Pass ☐ Fail |

---

### 3.5 Unit Tests

| Test ID | Test Beschrijving | Verwacht | Status |
|---|---|---|---|
| UT-01 | AllergeenControllerTest::test_allergen_filtering_returns_products_with_selected_allergen | 2+ producten gefilterd, gesorteerd A-Z | ☐ Pass ☐ Fail |
| UT-02 | AllergeenControllerTest::test_supplier_details_displays_contact_information | Supplier data en contact info beschikbaar | ☐ Pass ☐ Fail |

---

## 4. Testuitvoering

### Voorbereiding
1. Database resetten met SQL-script
2. Applicatie opkomen (php artisan serve)
3. Inloggen als manager
4. Navigate naar homepage

### Uitvoering
- Voer tests uit in volgorde
- Noteer eventuele fouten
- Screenshot voor Pass/Fail

### Cleanup
- Database state resetten
- Browser cache clearen

---

## 5. Acceptatie Criteria

✓ Alle 24 testcases = PASS\
✓ Beide unit tests = PASS\
✓ Geen console errors\
✓ Sortering A-Z gevalideerd\
✓ Pagination 4 items per page\
✓ Scenario 03 warning zichtbaar\

---

## 6. Problemen en Afwijkingen

| Probleem | Oorzaak | Oplossing | Status |
|---|---|---|---|
| | | | ☐ Open |

---

## 7. Goedkeuring

| Rol | Naam | Handtekening | Datum |
|---|---|---|---|
| Tester | Student | _________ | 5-3-2026 |
| Revisor | Docent | _________ | _____ |


## Testgevallen
- S1: Wijzig Astra Sweets (id=2) mobiel naar `06-39398825` en straatnaam naar `Den Dolderlaan` → melding succes en redirect na 3s.
- S2: Wijzig De Bron (id=5) mobiel naar `06-39398825` → melding storing en redirect na 3s.
- P1: Pagination op overzicht toont max 4 records en werkt met volgende/vorige.

## Voorwaarden
- Ingelogd als manager (acceptatie: homepagina bereikbaar).
- Database gevuld met testdata (seed of SQL).
- Stored procedures aangemaakt (`stored_procedures.sql`).

## Uitvoering
- Navigeer naar Home → "Wijzigen Leveranciers".
- Controleer paginering (4 per pagina).
- Open details via pen-icoon.
- Klik "Wijzig" → formulier.
- Vul waarden en klik "Sla Op".
- Observeer melding en automatische redirect.

## Verwachte resultaten
- S1: "De wijzigingen zijn doorgevoerd".
- S2: "Door een technische storing ... Probeer het op een later moment nog eens".
- Redirect telkens naar de juiste details-pagina na 3s.
