#-----------------------------------------------------------
# Docker
#-----------------------------------------------------------

# Start docker containers
start:
	docker-compose start

# Stop docker containers
stop:
	docker-compose stop

# Recreate docker containers
up:
	docker-compose up -d

# Stop and remove containers and networks
down:
	docker-compose down

# Stop and remove containers, networks, volumes and images
clean:
	docker-compose down --rmi local -v

ultra-clean:
	rm -rf $(wildcard node_modules/)
	rm -rf $(wildcard vendor/)
	rm $(wildcard composer.lock)
	docker-compose down --rmi local -v

# Restart all containers
restart: stop start

# Build and up docker containers
build:
	docker-compose build

# Build containers with no cache option
build-no-cache:
	docker-compose build --no-cache

# Build and up docker containers
rebuild: build up

env:
	[ -f .env ] && echo .env exists || cp .env.example .env

init: env up build install start

php-bash:
	./vendor/bin/sail bash

#-----------------------------------------------------------
# Database
#-----------------------------------------------------------

# Run database migrations
db-migrate:
	./vendor/bin/sail artisan migrate

# Run migrations rollback
db-rollback:
	./vendor/bin/sail artisan migrate:rollback

# Run last migration rollback
db-rollback-last:
	./vendor/bin/sail artisan migrate:rollback --step=1

# Run seeders
db-seed:
	./vendor/bin/sail artisan db:seed

# Fresh all migrations
db-fresh:
	./vendor/bin/sail artisan migrate:fresh

#-----------------------------------------------------------
# Linter
#-----------------------------------------------------------
pint:
	./vendor/bin/sail pint -v --test

# Fix code directly
pint-hard:
	./vendor/bin/sail pint -v

stan:
	./vendor/bin/sail bin phpstan analyse

lint:
	./vendor/bin/sail bin php-cs-fixer fix --diff -v
#--report="~\Users\uname\Desktop\PHPcs\PHPGOG.txt"
#analyze:
#	docker-compose run -u `id -u` --rm php composer psalm -- --no-diff

test:
	./vendor/bin/sail php artisan co:cle
	./vendor/bin/sail php artisan ca:cle
	./vendor/bin/sail php artisan test --type-coverage --min=100 --profile

#check: pint lint analyze test
check: pint lint test
style: pint-hard lint

#-----------------------------------------------------------
# Installation
#-----------------------------------------------------------

# Laravel
install:
	docker-compose stop
	cp .env.example .env
	chmod 755 ./sail
	./sail -f docker-compose.yml up -d --build
	./sail composer i
	./sail php artisan key:generate
	./sail php artisan migrate:fresh --seed
	./sail php artisan storage:link
