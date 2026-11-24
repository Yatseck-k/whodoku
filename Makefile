.PHONY: setup up down test frontend-test build

setup:
	mkdir -p dev-app/bootstrap/cache dev-app/storage/framework/cache/data dev-app/storage/framework/sessions dev-app/storage/framework/views dev-app/storage/logs
	docker compose build php
	docker compose run --rm php composer install --no-interaction
	docker compose run --rm node ci
	docker compose run --rm node run build
	docker compose run --rm php php dev-app/artisan migrate --force
	docker compose run --rm php php dev-app/artisan db:seed --class='Whodoku\Database\Seeders\DatabaseSeeder' --force
	docker compose run --rm php php dev-app/seed-demo.php
	docker compose run --rm php php dev-app/artisan vendor:publish --tag=whodoku-assets --force
	docker compose up -d php

up:
	docker compose up -d php

down:
	docker compose down

test:
	docker compose run --rm php composer test

frontend-test:
	docker compose run --rm node run test:whodoku
	docker compose run --rm node run typecheck:whodoku
	docker compose run --rm node run lint:whodoku

build:
	docker compose run --rm node run build
	docker compose run --rm php php dev-app/artisan vendor:publish --tag=whodoku-assets --force
