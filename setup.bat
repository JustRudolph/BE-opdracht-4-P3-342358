@echo off
REM Installation script for Allergen Overview Project (BE-opdracht-4-US01)
REM This script automates the setup and configuration of the Laravel project
REM Usage: setup.bat (or double-click)

setlocal enabledelayedexpansion

echo ======================================
echo Allergen Overview Project Setup
echo ======================================
echo.

REM Check if Laravel project exists
if not exist "artisan" (
    echo [ERROR] Laravel project not found!
    echo This script must be run from the project root directory.
    pause
    exit /b 1
)

echo [1/6] Install PHP dependencies...
where composer >nul 2>nul
if %errorlevel% neq 0 (
    echo [ERROR] Composer not found. Install Composer first.
    pause
    exit /b 1
)
call composer install --no-interaction
if %errorlevel% equ 0 (
    echo [OK] Dependencies installed
) else (
    echo [ERROR] Composer install failed
    pause
    exit /b 1
)

echo.
echo [2/6] Setup environment file...
if not exist ".env" (
    copy .env.example .env
    echo [OK] .env file created
) else (
    echo [WARN] .env file already exists
)

echo.
echo [3/6] Generate application key...
call php artisan key:generate
echo [OK] Application key generated

echo.
echo [4/6] Clear cache...
call php artisan config:clear
call php artisan cache:clear
echo [OK] Cache cleared

echo.
echo [5/6] Run database migrations...
call php artisan migrate --force
if %errorlevel% equ 0 (
    echo [OK] Migrations completed
) else (
    echo [ERROR] Migrations failed. Check database connection in .env
    pause
    exit /b 1
)

echo.
echo [6/6] Run database seeder?
set /p seeder="Do you want to seed test data? (y/n): "
if /i "%seeder%"=="y" (
    call php artisan db:seed --class=AllergenSeeder --force
    echo [OK] Test data seeded
) else (
    echo Seeding skipped
)

echo.
echo [OPTIONAL] Install JavaScript dependencies?
set /p jsdeps="Install npm dependencies? (y/n): "
if /i "%jsdeps%"=="y" (
    where npm >nul 2>nul
    if %errorlevel% equ 0 (
        call npm install
        call npm run dev
        echo [OK] JavaScript dependencies installed
    ) else (
        echo [ERROR] npm not found. Skipping...
    )
) else (
    echo npm installation skipped
)

echo.
echo ======================================
echo [OK] Setup completed successfully!
echo ======================================
echo.
echo Next steps:
echo 1. Update .env with your database credentials:
echo    - DB_HOST=127.0.0.1
echo    - DB_PORT=3306
echo    - DB_DATABASE=alergeen
echo    - DB_USERNAME=root
echo    - DB_PASSWORD=your_password
echo.
echo 2. Run the development server:
echo    php artisan serve
echo.
echo 3. Access the application at:
echo    http://localhost:8000
echo.
echo For more information, see ENVIRONMENT_SETUP.md
echo.
pause
