#!/usr/bin/env bash
set -e

cd /var/www/html

# .env は Render の環境変数で注入する想定
# APP_KEY が未設定だと落ちるので注意

php artisan optimize:clear || true

# storage link (public/storage)
php artisan storage:link || true

# DB migrate（本番は --force）
php artisan migrate --force

# Cache（本番は有効化推奨）
php artisan config:cache
php artisan route:cache
php artisan view:cache

exec supervisord -c /etc/supervisord.conf