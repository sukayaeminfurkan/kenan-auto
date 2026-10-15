# Kenan Auto

A website for a second-hand car dealership, built with Laravel. Dealership staff manage vehicles, brands, models, equipment packages and service points through an admin panel, and featured vehicles appear on the public homepage.

> **Status: in development.** The admin panel and homepage work. The public vehicle pages and the buy/sell forms are next (see [Roadmap](#roadmap)).

This is a personal project. "Kenan Auto" is used as the dealership's brand name.

## Features

**Admin panel** (`/admin`, admin users only)
- Vehicles: create, edit and delete vehicles; mark them as featured
- Photo upload (up to 10 images per vehicle, validated by type and size) with cover photo selection
- Brands → models → equipment packages as nested resources; dependent dropdowns load models and packages via JSON endpoints
- Service points with logo, city, category and an active flag

**Public homepage**
- Responsive landing page with "buy" and "sell" entry panels
- Featured vehicles carousel (cover photo, fuel type, transmission, mileage)
- Service points section and contact links

**Other**
- Authentication via Laravel Breeze, with an `is_admin` flag and custom admin middleware
- Artisan command `temizle:yetim-fotograflar` removes photo files that have no database record
- Seeders for common car brands/models and example equipment packages

## Tech Stack

| Layer | Technology |
|---|---|
| Backend | Laravel 13, PHP 8.3+ |
| Frontend | Blade, Tailwind CSS, vanilla JavaScript |
| Database | MariaDB / MySQL |
| Build | Vite |
| Auth | Laravel Breeze |

## Getting Started

```bash
git clone https://github.com/sukayaeminfurkan/kenan-auto.git
cd kenan-auto

composer install
cp .env.example .env
php artisan key:generate

# Set your database connection in .env, then:
php artisan migrate
php artisan db:seed --class=MarkaModelSeeder
php artisan db:seed --class=PaketSeeder
php artisan storage:link

npm install && npm run build
php artisan serve
```

**Admin access:** Register a user at `/register`, then grant admin rights:

```bash
php artisan tinker --execute="App\Models\User::where('email', 'you@example.com')->update(['is_admin' => true]);"
```

## Roadmap

- [ ] Vehicle listing page (`/araclarimiz`) with filters (brand, model, year, price, fuel type)
- [ ] Vehicle detail page with photo gallery
- [ ] "Sell your car" request form (`/arac-sat`); the `arac_talepler` table already exists
- [ ] Image optimisation (WebP)
- [ ] Feature tests for the admin panel

## Author

Emin Furkan Sukaya · [LinkedIn](https://www.linkedin.com/in/emin-furkan-sukaya-821513245/)

© 2026 Emin Furkan Sukaya. All rights reserved. The source code is published for portfolio purposes.

