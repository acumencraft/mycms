#!/bin/bash
echo "=== 🚀 Deploying to Production ==="

# 1. Build locally
echo "→ Building assets..."
npm run build

# 2. Push to GitHub
echo "→ Pushing to GitHub..."
git add -A
git commit -m "Deploy: $(date '+%Y-%m-%d %H:%M')" 2>/dev/null || echo "Nothing to commit"
git push origin main

# 3. Deploy on server
echo "→ Deploying on server..."
ssh -i ~/.ssh/hostinger_archvadze -p 65002 u831949347@82.25.96.134 << 'ENDSSH'
cd domains/archvadze.com
git pull origin main
composer install --no-dev --optimize-autoloader --no-interaction
php artisan migrate --force
php artisan optimize:clear
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan storage:link 2>/dev/null || true
echo "=== ✅ Deploy Complete ==="
ENDSSH

# 4. Copy built assets
echo "→ Copying built assets..."
scp -i ~/.ssh/hostinger_archvadze -P 65002 -r public/build u831949347@82.25.96.134:domains/archvadze.com/public_html/

echo "=== ✅ All Done! ==="
