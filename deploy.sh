#!/bin/bash
echo "=== Archvadze Production Deploy ==="

php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan storage:link

echo "=== Done! ==="
