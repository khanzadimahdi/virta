dc := docker-compose
exec := $(dc) exec
up := $(dc) up -d
phpcommand := $(exec) -e XDEBUG_MODE=off web php
composer := $(exec) -T web composer


.EXPORT_ALL_VARIABLES:
APP_ENV=local
WEB_FORWARD_PORT=80
MYSQL_FORWARD_PORT=3306
MAILHOG_FORWARD_PORT=1025
MAILHOG_DASHBOARD_FORWARD_PORT=8025
FORWARD_SWAGGER_UI_PORT=8080
CONSUMER_FORWARD_PORT=8000
DB_DATABASE=virta
DB_USERNAME=virta
DB_PASSWORD=root


setup:
	cp .env.example .env
	$(up)
	$(composer) install
	$(phpcommand) ./artisan key:generate
	$(phpcommand) ./artisan migrate:fresh
	$(exec) -T consumer composer install

up:
	$(up)

down:
	$(dc) down --remove-orphans

restart:
	$(dc) restart

hard_restart:
	$(dc) down --remove-orphans
	$(dc) up -d --force-recreate --build

destroy:
	$(dc) down -v --remove-orphans

bash:
	$(exec) web bash

mysql:
	$(dc) mysql exec mysql mysql -u$$DB_USERNAME -p$$DB_PASSWORD

seed:
	$(phpcommand) ./artisan db:seed

openapi:
	$(phpcommand) ./vendor/bin/openapi ./app -o wiki/swagger.yaml

composer_install:
	$(composer) install

composer_autoload:
	$(composer) dump-autoload

test:
	$(phpcommand) artisan test

phpunit:
	$(exec) web ./vendor/bin/phpunit

phpstan:
	$(exec) web ./vendor/bin/phpstan analyse --memory-limit=1G ./app

phpcs:
	$(exec) web ./vendor/bin/phpcs

phpcbf:
	$(exec) web ./vendor/bin/phpcbf
