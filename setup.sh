#!/bin/bash
# Installation script for Allergen Overview Project (BE-opdracht-4-US01)
# This script automates the setup and configuration of the Laravel project
# Usage: bash setup.sh

echo "======================================"
echo "Allergen Overview Project Setup"
echo "======================================"
echo ""

# Colors for output
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
NC='\033[0m' # No Color

# Check if Laravel project exists
if [ ! -f "artisan" ]; then
    echo -e "${RED}Error: Laravel project not found!${NC}"
    echo "This script must be run from the project root directory."
    exit 1
fi

echo -e "${YELLOW}Step 1: Install PHP dependencies...${NC}"
if command -v composer &> /dev/null; then
    composer install --no-interaction
    echo -e "${GREEN}✓ Dependencies installed${NC}"
else
    echo -e "${RED}✗ Composer not found. Install Composer first.${NC}"
    exit 1
fi

echo ""
echo -e "${YELLOW}Step 2: Setup environment file...${NC}"
if [ ! -f ".env" ]; then
    cp .env.example .env
    echo -e "${GREEN}✓ .env file created${NC}"
else
    echo -e "${YELLOW}! .env file already exists${NC}"
fi

echo ""
echo -e "${YELLOW}Step 3: Generate application key...${NC}"
php artisan key:generate
echo -e "${GREEN}✓ Application key generated${NC}"

echo ""
echo -e "${YELLOW}Step 4: Clear cache...${NC}"
php artisan config:clear
php artisan cache:clear
echo -e "${GREEN}✓ Cache cleared${NC}"

echo ""
echo -e "${YELLOW}Step 5: Run database migrations...${NC}"
php artisan migrate --force
echo -e "${GREEN}✓ Migrations completed${NC}"

echo ""
echo -e "${YELLOW}Step 6: Run database seeder (optional)...${NC}"
read -p "Do you want to seed test data? (y/n) " -n 1 -r
echo
if [[ $REPLY =~ ^[Yy]$ ]]; then
    php artisan db:seed --class=AllergenSeeder --force
    echo -e "${GREEN}✓ Test data seeded${NC}"
else
    echo "Seeding skipped"
fi

echo ""
echo -e "${YELLOW}Step 7: Install JavaScript dependencies (optional)...${NC}"
read -p "Install npm dependencies? (y/n) " -n 1 -r
echo
if [[ $REPLY =~ ^[Yy]$ ]]; then
    if command -v npm &> /dev/null; then
        npm install
        npm run dev
        echo -e "${GREEN}✓ JavaScript dependencies installed${NC}"
    else
        echo -e "${RED}✗ npm not found. Skipping...${NC}"
    fi
else
    echo "npm installation skipped"
fi

echo ""
echo "======================================"
echo -e "${GREEN}✓ Setup completed successfully!${NC}"
echo "======================================"
echo ""
echo "Next steps:"
echo "1. Update .env with your database credentials:"
echo "   - DB_HOST=127.0.0.1"
echo "   - DB_PORT=3306"
echo "   - DB_DATABASE=alergeen"
echo "   - DB_USERNAME=root"
echo "   - DB_PASSWORD=your_password"
echo ""
echo "2. Run the development server:"
echo "   php artisan serve"
echo ""
echo "3. Access the application at:"
echo "   http://localhost:8000"
echo ""
echo "For more information, see ENVIRONMENT_SETUP.md"
