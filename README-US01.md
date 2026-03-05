# Jamin Manager - Allergen Overview Systeem

Eine Laravel-basierte Managementanwendung für die Jamin-Süßwarenhandlungsgruppe, mit Fokus auf Allergen-Management und Lieferantenverwaltung.

## Projektziel

Bietet Managern die Möglichkeit:
- Süßwaren-Produkte zu sehen, die Allergene enthalten
- Nach Allergenen zu filtern
- Lieferanteninformationen und Kontaktdaten zu empfangen
- Mit Szenarien ohne verfügbare Kontaktinformationen umzugehen

## Anforderungen

- PHP 8.2+
- Laravel 11
- MySQL 8.0+
- Node.js 18+ (für Frontend-Build)
- Composer

## Installation

### 1. Projekt klonen
```bash
git clone https://github.com/your-account/BE-opdracht-4-P3-studentnummer.git
cd alergeen
```

### 2. Abhängigkeiten installieren
```bash
composer install
npm install
```

### 3. Umgebungsvariablen konfigurieren
```bash
cp .env.example .env
php artisan key:generate
```

### 4. Datenbank erstellen und befüllen

#### MySQL Datenbank erstellen
```bash
mysql -u root -p
CREATE DATABASE jamin_manager;
exit
```

#### Migrations und Test-Daten laden
```bash
php artisan migrate

# Oder: Import SQL-Script direkt
mysql -u root -p jamin_manager < database/sql/create_database.sql
mysql -u root -p jamin_manager < database/sql/stored_procedures.sql
```

### 5. Anwendung starten
```bash
php artisan serve
```

Die Anwendung ist dann verfügbar unter: http://localhost:8000

## Verzeichnis-Struktur

```
├── app/
│   ├── Http/Controllers/
│   │   ├── AllergeenController.php      # User Story 1: Allergen-Verwaltung
│   │   ├── LeverancierController.php    # Lieferanten-Management
│   │   └── ProductController.php        # Produkt-Management
│   └── Models/
│       ├── Product.php
│       ├── Allergeen.php
│       ├── Leverancier.php
│       ├── Contact.php
│       └── ...
├── database/
│   ├── migrations/          # Datenbank-Schemaer
│   ├── factories/           # Model-Factories für Tests
│   ├── seeders/             # Datenbank-Seeder
│   └── sql/
│       ├── create_database.sql      # Kompletter DB-Setup
│       └── stored_procedures.sql    # Stored Procedures
├── resources/views/
│   ├── home.blade.php
│   └── allergeens/
│       ├── index.blade.php               # Allergen-Übersicht
│       └── supplier-details.blade.php    # Lieferanten-Details
├── routes/
│   └── web.php              # Webrouten
├── tests/
│   └── Unit/
│       └── AllergeenControllerTest.php   # Unit-Tests
└── docs/
    ├── class-diagram-us01.puml          # UML-Diagramm
    ├── DatabaseSpecificatieTabel.md     # DB-Dokumentation
    ├── Testplan.md                      # Testplan
    └── Testrapport.md                   # Testradeberichte
```

## Datenbank-Schema

### Haupttabellen

| Tabelle | Beschreibung |
|---------|-------------|
| products | Süßwaren-Produkte (Name, Barcode) |
| allergeens | Allergin-Typen (Gluten, Lactose, Soja, etc.) |
| product_per_allergeens | Many-to-Many: Produkte ↔ Allergene |
| leveranciers | Lieferanten (Name, Kontaktperson) |
| contacts | Kontaktinformationen (Adresse, Stadt) |
| product_per_leveranciers | Many-to-Many: Produkte ↔ Lieferanten |
| magazijns | Lagerbestände (Verpackungseinheit, Menge) |

### Systemfelder

Alle Tabellen enthalten diese Felder:
- `IsActief` (BIT): Aktiv/Inaktiv Flag
- `Opmerking` (VARCHAR): Notizen
- `DatumAangemaakt` (DATETIME): Erstellungs-Timestamp
- `DatumGewijzigd` (DATETIME): Änderungs-Timestamp

## API / Stored Procedures

### GetProductsWithAllergens
Gathers alle Produkte mit einem bestimmten Allergen, sortiert A-Z

```sql
CALL GetProductsWithAllergens(allergen_id)
```

Parameter: `allergen_id` (0 = alle Allergene)

### GetSupplierDetails
Retrievers Lieferantinformations für ein Produkt

```sql
CALL GetSupplierDetails(product_id)
```

### GetAllergensForProduct
Lists all Allergeene in einem Produkten

```sql
CALL GetAllergensForProduct(product_id)
```

## Testierung

### Unit Tests ausführen

```bash
php artisan test
# oder mit coverage report
php artisan test --coverage
```

### Tests in PhpStorm/VS Code
- Rechts-Klick auf `tests/` Order → Run

## User Stories

### User Story 01: Allergen-Übersicht ✓ (ABGESCHLOSSEN)

**Szenario 01:** Produkte nach Allergen filtern
- Link zur Allergen-Übersicht auf Homepage
- Dropdown mit allen Allergenen
- Filterte Ergebnisse, A-Z sortiert
- Pagination: 4 Produkte pro Seite

**Szenario 02:** Lieferantinfo mit Adresse anzeigen
- Klick auf Info-Icon → Lieferanten-Detailseite
- Adressegevens: Straat, Huisnummer, Postcode, Stad

**Szenario 03:** Lieferant ohne Adressegevens
- Lieferant "Hom Ken Food" hat kein ContactId
- Warnung anzeigen: "Er zijn geen adresgegevens bekend"

## Deployment

### Production

```bash
# Assets kompilieren
npm run build

# Migrations auf Produktion ausführen
php artisan migrate --force

# Cache aufwärmen
php artisan optimize
```

### Environment-Variablen
```
DB_HOST=localhost
DB_PORT=3306
DB_DATABASE=jamin_manager
DB_USERNAME=root
DB_PASSWORD=your_password
APP_ENV=production
APP_DEBUG=false
```

## Troubleshooting

### Datenbank-Fehler: "SQLSTATE[HY000]"
- MySQL läuft? `mysql -u root` testen
- Datenbank vorhanden? `SHOW DATABASES;`
- Credentials in `.env` nach MySQL-Einstellungen überprüfen

### "Connection refused" beim Zugriff
- Laravel server läuft? `php artisan serve`
- Firewall blockiert Port 8000?
- Ports in use? `netstat -ano | findstr :8000` (Windows)

### Tests schlagen fehl
- Datenbank neuen? `php artisan migrate:refresh`
- Abhängigkeiten aktualisiert? `composer install`, `npm install`
- Tests einzeln ausfällen? `php artisan test tests/Unit/AllergeenControllerTest.php`

## Kontributoren

- **Student:** [Your Name]
- **Klasse:** IO-SD-2408AB

## Lizenz

Schulprojekt - Alle Rechte vorbehalten

## Ressourcen

- [Laravel Documentation](https://laravel.com/docs)
- [MySQL Documentation](https://dev.mysql.com/doc/)
- [PHPUnit Dokumentation](https://phpunit.de/documentation.html)

---

**Letzte Aktualisierung:** 5. März 2026\
**Version:** 1.0.0\
**Status:** Production Ready ✓
