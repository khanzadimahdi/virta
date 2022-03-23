#!/usr/bin/env bash

set -e

role=${CONTAINER_ROLE:-web}
env=${APP_ENV:-production}

if [ "$env" != "local" ]; then
    echo "Caching configuration..."
    (cd /var/www/html && php artisan optimize)
fi

if [ "$role" = "web" ]; then

    if [ "$env" != "local"]; then
        echo "Running migrations..."
        php /var/www/html/artisan migrate --force
    fi
    exec apache2-foreground

elif [ "$role" = "queue" ]; then

    php /var/www/html/artisan queue:work --queue=${QUEUE_NAME:-default}

elif [ "$role" = "schedule" ]; then

    while [ true ]
    do
      php /var/www/html/artisan schedule:run --verbose --no-interaction &
      sleep 60
    done

else

    echo "Could not match the container role \"$role\""
    exit 1

fi
