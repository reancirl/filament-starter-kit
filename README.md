# Setup Instructions

Follow these steps to set up the application:

```bash
npm install && npm run build
php artisan migrate --seed
php artisan permissions:sync
composer run dev
```