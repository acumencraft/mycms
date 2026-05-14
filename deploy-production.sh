#!/bin/bash
echo "=== Deploying to Production ==="

echo "→ Building assets..."
npm run build

echo "→ Pushing to GitHub..."
git add -A
git commit -m "Deploy: $(date '+%Y-%m-%d %H:%M')" 2>/dev/null || echo "Nothing to commit"
git push origin main

echo "→ Deploying on server..."
ssh -i ~/.ssh/hostinger_archvadze -p 65002 u831949347@82.25.96.134 << 'ENDSSH'
cd domains/archvadze.com/laravel
git fetch origin
git reset --hard origin/main
composer install --no-dev --optimize-autoloader --no-interaction
php artisan migrate --force
php artisan optimize:clear
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan filament:assets
cp -r public/css /home/u831949347/domains/archvadze.com/public_html/
cp -r public/js /home/u831949347/domains/archvadze.com/public_html/
cp -r public/fonts /home/u831949347/domains/archvadze.com/public_html/
echo "=== Deploy Complete ==="
ENDSSH

echo "→ Copying built assets..."
scp -i ~/.ssh/hostinger_archvadze -P 65002 -r public/build u831949347@82.25.96.134:domains/archvadze.com/public_html/

echo "=== All Done! ==="
