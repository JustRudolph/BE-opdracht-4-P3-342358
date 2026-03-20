# Jamin Warehouse Management System - Setup & Startup Guide

Welkom bij het Jamin Warehouse Management System. Dit document bevat alles wat je nodig hebt om het project op te zetten en te starten.

## 📋 Inhoudsopgave

- [Vereisten](#vereisten)
- [Installatie](#installatie)
- [Configuratie](#configuratie)
- [Database Setup](#database-setup)
- [Applicatie Starten](#applicatie-starten)
- [Gebruikshandleiding](#gebruikshandleiding)
- [Testen](#testen)
- [Troubleshooting](#troubleshooting)

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

# Linux/Mac
mysql -u root -p < database/scripts/create_database.sql
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

# Linux/Mac
mysql -u root -p alergeen < database/scripts/stored_procedures.sql
```

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

### Methode 2: Docker (Indien beschikbaar)

```bash
docker-compose up -d
```

### Methode 3: Apache/Nginx

Configureer je webserver om naar de `public/` directory te wijzen.

## 📖 Gebruikshandleiding

### Toegang tot de Applicatie

Open je browser en navigeer naar:

```
http://localhost:8000
```

### Belangrijkste Features

#### 1. Overzicht Geleverde Producten
- Navigeer naar `/delivered-products`
- Optioneel: selecteer een datumbereik
- Bekijk alle geleverde producten met paginering (4 per pagina)

#### 2. Product Specificaties
- Klik op de "?" knop in het overzicht
- Bekijk gedetailleerde leveringshistorie per product

#### 3. Allergenfiltering
- Gebruik de allergen filters om producten te vinden met bepaalde allergenen

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

## 🐛 Troubleshooting

### Probleem: "SQLSTATE[HY000]: General error: 1030"

**Oorzaak:** Database niet gevonden  
**Oplossing:** 
```bash
php artisan migrate
mysql -u root -p < database/scripts/create_database.sql
```

### Probleem: "Class 'PDO' not found"

**Oorzaak:** PHP PDO extensie is niet ingeschakeld  
**Oplossing:**
- Windows: Activeer `extension=pdo_mysql` in `php.ini`
- Linux: `sudo apt-get install php8.4-mysql`

### Probleem: "MySQL Connection refused"

**Oorzaak:** MySQL server draait niet  
**Oplossing:**
- Windows: `mysql.exe -u root -p`
- Linux: `sudo systemctl start mysql` of `sudo service mysql start`
- Mac: `brew services start mysql`

### Probleem: "Port 8000 is already in use"

**Oplossing:** Gebruik een ander poort
```bash
php artisan serve --port=8001
```

### Probleem: Statische bestanden laden niet

**Oplossing:** 
```bash
php artisan storage:link
npm run build
```

## 📚 Aanvullende Bronnen

- [Laravel Documentatie](https://laravel.com/docs)
- [MySQL Documentatie](https://dev.mysql.com/doc/)
- [Blade Templating](https://laravel.com/docs/blade)
- [Database Specificatie](docs/DatabaseSpecification.md)
- [Feature Documentatie](docs/FEATURE_README.md)
- [Test Plan](docs/Testplan.md)

## 📞 Ondersteuning

Bij problemen:
1. Controleer de [Troubleshooting](#troubleshooting) sectie
2. Lees de gerelateerde documentatie in de `docs/` map
3. Run `php artisan test` om de gezondheid te controleren

## 📄 Licentie

Dit project is gelicentieerd onder de MIT licentie.

---

**Veel succes met het Jamin Warehouse Management System! 🎉**
