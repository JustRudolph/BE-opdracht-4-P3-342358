# Testplan - BE-opdracht 03

- Project: Jamin Manager (Laravel)
- User story: Wijzigen Leverancier (US01)
- Scope: Scenario_01 (succes) en Scenario_02 (technische storing)

## Testomgeving
- DB: MySQL 8
- Framework: Laravel 11
- Browser: Chromium/Firefox/Edge

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
