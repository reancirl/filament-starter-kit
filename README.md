# Setup Instructions

Follow these steps to set up the application:

```bash
npm install && npm run build
php artisan migrate --seed
php artisan permissions:sync
php artisan permissions:sync -P
composer run dev

# Deployment
php artisan filament:optimize
php artisan filament:optimize-clear
php artisan optimize:clear
```