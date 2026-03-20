# Jamin Warehouse Management System - Setup & Startup Guide

Welkom bij het Jamin Warehouse Management System. Dit document bevat alles wat je nodig hebt om het project op te zetten en te starten.

## 🔧 Vereisten

Zorg ervoor dat je de volgende software hebt geïnstalleerd:

- **PHP 8.3+** - De programmeertaal waarop Laravel draait
- **Composer** - PHP package manager (installeren van [getcomposer.org](https://getcomposer.org))
- **MySQL 8.0+** - Database server
- **Node.js 18+** (optioneel) - Voor frontend build tools
- **Git** - Voor versiebeheer

## 📦 Installatie

### 1. Project Klonen

```bash
git clone https://github.com/JustRudolph/BE-opdracht-4-P3-342358.git
cd alergeen
```

### 2. Afhankelijkheden Installeren

```bash
# PHP afhankelijkheden
composer install

# Node afhankelijkheden (optioneel, voor frontend build)
npm install
```

### 3. Environment Bestand

Maak een kopie van het .env.example bestand:

```bash
cp .env.example .env
```

### 4. Application Key Genereren

```bash
php artisan key:generate
```

## ⚙️ Configuratie

### 1. Database Verbinding

Edit het `.env` bestand en stel de database instellingen in:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=alergeen
DB_USERNAME=root
DB_PASSWORD=
```

- **DB_HOST**: Je MySQL server adres (meestal `127.0.0.1` lokaal)
- **DB_PORT**: MySQL poort (standaard `3306`)
- **DB_DATABASE**: Naam van de database (`alergeen`)
- **DB_USERNAME**: Je MySQL gebruikersnaam (standaard `root`)
- **DB_PASSWORD**: Je MySQL wachtwoord (leeg indien niet ingesteld)

### 2. App Configuratie (Optioneel)

Andere belangrijke instellingen in `.env`:

```env
APP_NAME="Allergen Warehouse"
APP_URL=http://localhost:8000
MAIL_FROM_ADDRESS=no-reply@allergen.local
```

## 🗄️ Database Setup

### 1. Database Aanmaken

Zorg eerst dat MySQL draait. Maak vervolgens de database aan:

```bash
# Windows
mysql -u root -p < database\scripts\create_database.sql
```

Dit script zal:
- Database `alergeen` aanmaken
- Alle tabellen creëren
- Test data vullen
- Relaties instellen

### 2. Stored Procedures Toevoegen

```bash
# Windows
mysql -u root -p alergeen < database\scripts\stored_procedures.sql

Dit voegt de volgende procedures toe:
- `sp_GetDeliveredProductsByDateRange()` - Haalt leveringen op per datum
- `sp_GetProductDeliverySpecifications()` - Geeft details per product
- `sp_CountDeliveredProductsByDateRange()` - Telt leveringen

### 3. Migraties Uitvoeren

```bash
php artisan migrate
```

Dit past alle database migraties toe.

### 4. Database Seeden (Optioneel)

```bash
php artisan db:seed
```

Dit vult aanvullende testdata in.

## 🚀 Applicatie Starten

### Methode 1: Laravel Development Server (Aanbevolen)

```bash
php artisan serve
```

Dit start de applicatie op `http://localhost:8000`

## 📖 Gebruikshandleiding

### Toegang tot de Applicatie

Open je browser en navigeer naar:

```
http://localhost:8000
```

## 🧪 Testen

### Tests Uitvoeren

```bash
# Alle tests
php artisan test

# Met gedetailleerde output
php artisan test --testdox

# Specifieke test bestand
php artisan test tests/Feature/DeliveredProductsControllerTest.php
```

### Test Coverage Controleren

```bash
php artisan test --coverage
```

### Huidige Test Status

- ✅ **11 Tests** - Alle PASSING
- ✅ **38 Assertions** - 100% geslaagd
- ✅ **76% Code Coverage** - Grade A
