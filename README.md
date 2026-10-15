# Kenan Auto 🚗

A modern second-hand car marketplace platform built for Kenan Auto Gallery.
Customers can browse vehicles, submit sell requests, and consignment listings
are managed entirely through the admin panel.

## Features

- Vehicle listings with advanced filters (brand, model, year, price, fuel type)
- Vehicle detail pages with photo gallery
- Sell / consignment request forms
- Full admin panel (vehicles, brands, models, packages, service points)
- Photo upload system with cover photo selection
- Mobile-first responsive design

## Tech Stack

| Layer | Technology |
|-------|-----------|
| Backend | Laravel 13.7, PHP 8.4 |
| Frontend | Tailwind CSS, Vanilla JS |
| Database | MariaDB |
| Build | Vite |
| Auth | Laravel Breeze |

## Getting Started

```bash
git clone https://github.com/sukayaeminfurkan/kenan-auto.git
cd kenan-auto

composer install --ignore-platform-reqs
cp .env.example .env
php artisan key:generate

# Configure your database in .env, then:
php artisan migrate --seed
php artisan storage:link

npm install && npm run build
php artisan serve
```

## Admin Panel

Access via `/admin` after seeding. Manage vehicles, brands,
models, packages, and service points from a single dashboard.

## License

Private — All rights reserved © Kenan Auto
