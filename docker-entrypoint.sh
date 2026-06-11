#!/bin/sh
set -e

# Wait for MySQL to be ready
echo "Waiting for database connection at $DB_HOST:$DB_PORT..."
until mysqladmin ping -h"$DB_HOST" -P"$DB_PORT" --silent; do
    echo "Database is not ready yet, retrying in 2 seconds..."
    sleep 2
done
echo "Database is ready!"

# Run migrations if database is empty or updates exist
echo "Running database migrations..."
php artisan migrate --force

# Optimize Laravel configurations for production
echo "Caching Laravel configuration, routes, and views..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Execute the main container command
echo "Starting application server..."
exec "$@"
