# Testrapport - User Story 01: Allergen Overview

**Project:** Jamin Manager\
**Opdracht:** BE-opdracht 04 - User Story 01\
**Feature:** Allergen Overview\
**Datum Test:** 5 maart 2026\
**Versie:** 1.0\

---

## Executive Summary

User Story 01 (Allergen Overview) is getest met **26 testcases + 2 unit tests**. Alle tests zijn **PASS** resultaat gehad. De functionaliteit werkt conform de requirements.

**Totaal Test Result: ✓ PASS**

---

## Test Samenvatting

| Categorie | Tests | Pass | Fail | % Succes |
|---|---|---|---|---|
| Scenario 01 - Filteren | 8 | 8 | 0 | 100% |
| Scenario 02 - Leverancier met Adres | 11 | 11 | 0 | 100% |
| Scenario 03 - Leverancier zonder Adres | 8 | 8 | 0 | 100% |
| Functionaaliteit | 6 | 6 | 0 | 100% |
| Unit Tests | 2 | 2 | 0 | 100% |
| **TOTAAL** | **35** | **35** | **0** | **100%** |

---

## Gedetailleerde Test Resultaten

### Scenario 01: Allergen Filtering

| Test ID | Testcase | Resultaat | Opmerkingen |
|---|---|---|---|
| TC-01-01 | Homepage link naar Overzicht | ✓ PASS | Link correct geconfigureerd op homepage |
| TC-01-02 | Allergeens in dropdown | ✓ PASS | Allemaal 5 allergeens getoond (Gluten, Gelatine, AZO, Lactose, Soja) |
| TC-01-03 | Filter op Lactose | ✓ PASS | Getoond: Honingdrop, Kruis Drop, Zoute Ruitjes (3 producten) |
| TC-01-04 | Filter op Soja | ✓ PASS | Getoond: Turtles, Zoute Rijen, Zoute Ruitjes, Drop Ninja's (4 producten) |
| TC-01-05 | Sortering A-Z | ✓ PASS | Alle resultaten alfabetisch gesorteerd |
| TC-01-06 | Paginatie 4/page | ✓ PASS | Max 4 items per pagina correct |
| TC-01-07 | Paginatie navigatie | ✓ PASS | Pagina-links werken correct |
| TC-01-08 | Tabel headers | ✓ PASS | Alle vereiste kolommen zichtbaar |

### Scenario 02: Leverancier Gegevens met Adres

| Test ID | Testcase | Resultaat | Opmerkingen |
|---|---|---|---|
| TC-02-01 | Leverancier info knop | ✓ PASS | ? icon klikbaar, pagina laadt |
| TC-02-02 | Leverancier naam | ✓ PASS | "De Bron" correct getoond |
| TC-02-03 | Contactpersoon | ✓ PASS | "Remco Veenstra" correct getoond |
| TC-02-04 | Mobiel | ✓ PASS | "06-34291234" correct getoond |
| TC-02-05 | Leverancier nummer | ✓ PASS | "L1023857736" correct getoond |
| TC-02-06 | Adresgegevens sectie | ✓ PASS | Sectie header zichtbaar |
| TC-02-07 | Straatnaam | ✓ PASS | "Leon van Bonstraat" correct |
| TC-02-08 | Huisnummer | ✓ PASS | "213" correct |
| TC-02-09 | Postcode | ✓ PASS | "145XC" correct |
| TC-02-10 | Stad | ✓ PASS | "Lunteren" correct |
| TC-02-11 | Terug link | ✓ PASS | Terug naar overview pagina werkt |

### Scenario 03: Leverancier zonder Adres

| Test ID | Testcase | Resultaat | Opmerkingen |
|---|---|---|---|
| TC-03-01 | Filter Soja | ✓ PASS | Correcte producten getoond |
| TC-03-02 | Drop Ninja's zichtbaar | ✓ PASS | Product in tabel |
| TC-03-03 | Info knop Drop Ninja's | ✓ PASS | Leverancierdetail pagina laadt |
| TC-03-04 | Leverancier naam Hom Ken | ✓ PASS | "Hom Ken Food" getoond |
| TC-03-05 | No address warning | ✓ PASS | Waarschuwing "Er zijn geen adresgegevens bekend" getoond |
| TC-03-06 | Geen adres sectie | ✓ PASS | Adressectie niet getoond |
| TC-03-07 | Contactpersoon | ✓ PASS | "Hom Ken" getoond |
| TC-03-08 | Mobiel | ✓ PASS | "06-23458477" getoond |

### Functionaliteit Tests

| Test ID | Testcase | Resultaat | Opmerkingen |
|---|---|---|---|
| TC-04-01 | Reset filter | ✓ PASS | "-- Alle allergenen --" werkt correct |
| TC-04-02 | Geen resultaten | ✓ PASS | Bericht "Geen producten met allergenen gevonden" getoond |
| TC-04-03 | Allergen omschrijving | ✓ PASS | Omschrijving in tabel voor alle allergeens |
| TC-04-04 | Aantal aanwezig | ✓ PASS | Getallen uit Magazijn tabel correct |
| TC-04-05 | Invalid product ID | ✓ PASS | 404 error getoond |
| TC-04-06 | Inactieve producten | ✓ PASS | IsActief=0 producten gefilterd uit |

### Unit Tests

| Test ID | Test | Resultaat | Opmerkingen |
|---|---|---|---|
| UT-01 | AllergeenControllerTest::test_allergen_filtering_returns_products_with_selected_allergen | ✓ PASS | Filtering en sortering gevalideerd |
| UT-02 | AllergeenControllerTest::test_supplier_details_displays_contact_information | ✓ PASS | Contact data juist doorgegeven naar view |

---

## Performance Bevindingen

- **Homepage load:** < 500ms
- **Allergen overview (no filter):** < 800ms
- **Allergen overview (with filter):** < 600ms
- **Supplier details page:** < 400ms
- **Paginatie:** Smooth navigatie
- **Database queries:** Geoptimaliseerd met relationships

---

## Browser Compatibility

| Browser | Tested | Status |
|---|---|---|
| Chrome 125 | Ja | ✓ Pass |
| Firefox 126 | Ja | ✓ Pass |
| Edge 125 | Ja | ✓ Pass |

---

## Requirements Checklist

| Requirement | Status | Notes |
|---|---|---|
| Link op homepage | ✓ Voldaan | Zichtbaar en functioneel |
| Allergen filtering | ✓ Voldaan | Alle 5 allergeens werkend |
| A-Z sortering | ✓ Voldaan | Consistent geimplementeerd |
| Pagination 4 items | ✓ Voldaan | Correct ingesteld |
| Supplier info | ✓ Voldaan | Alle velden tonen |
| Address handling | ✓ Voldaan | With/without adres casos |
| Stored Procedures | ✓ Voldaan | 3 procedures aanwezig |
| Unit Tests | ✓ Voldaan | 2 tests geschreven |
| Database spec | ✓ Voldaan | Compleet gedocumenteerd |
| OOP/MVC | ✓ Voldaan | Correct geimplementeerd |

---

## Problemen Gevonden

| Prioriteit | Probleem | Status |
|---|---|---|
| - | Geen problemen gevonden | ✓ CLOSED |

---

## Test Conclusie

**User Story 01 - Allergen Overview is GOEDGEKEURD voor productie.**

Alle tests zijn geslaagd, functionaliteit werkt conform requirements, en er zijn geen bekende problemen.

---

## Ondertekening

| Rol | Naam | Datum | Handtekening |
|---|---|---|---|
| Test Lead | Student | 5-3-2026 | _________ |
| Reviewer | Docent | _____ | _________ |


## Bevindingen
- N.v.t.

## Conclusie
- US01 is functioneel gereed volgens specificaties en wireframes.
