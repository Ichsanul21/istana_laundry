#!/usr/bin/env bash
set -euo pipefail

cd "$(dirname "$0")"

echo "[deploy] $(date '+%Y-%m-%d %H:%M:%S') start"

echo "[deploy] git pull"
git pull origin main

cd backend

if command -v composer >/dev/null 2>&1 && [ -f composer.lock ]; then
    echo "[deploy] composer install"
    composer install --no-dev --no-interaction --prefer-dist --optimize-autoloader
fi

echo "[deploy] migrate"
php artisan migrate --force

echo "[deploy] storage:link"
php artisan storage:link 2>/dev/null || true

echo "[deploy] cache build"
php artisan config:cache 2>/dev/null || true
php artisan route:cache 2>/dev/null || true
php artisan view:cache 2>/dev/null || true

if command -v systemctl >/dev/null 2>&1; then
    for svc in php8.3-fpm php8.2-fpm php8.1-fpm php8.0-fpm php7.4-fpm php-fpm; do
        if systemctl list-unit-files --no-legend 2>/dev/null | grep -q "^${svc}\.service"; then
            echo "[deploy] restart ${svc}"
            sudo -n systemctl restart "${svc}" 2>/dev/null || true
            break
        fi
    done
fi

echo "[deploy] $(date '+%Y-%m-%d %H:%M:%S') done"