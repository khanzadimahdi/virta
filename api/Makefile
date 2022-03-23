all: say_hello

say_hello:
	@echo "Hello World!"

up:
	@docker-compose up -d

down:
	@docker-compose down --remove-orphans

restart:
	@docker-compose down --remove-orphans
	@docker-compose up -d

bash:
	@docker-compose exec web bash

composer_install:
	@docker-compose exec web composer install

composer_autoload:
	@docker-compose exec web composer dump-autoload

phpunit:
	@docker-compose exec web ./vendor/bin/phpunit

phpstan:
	@docker-compose exec web ./vendor/bin/phpstan analyse --memory-limit=1G

phpcs:
	@docker-compose exec web ./vendor/bin/phpcs
