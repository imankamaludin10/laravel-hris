# Makefile Laravel + Docker

up:
	docker compose up -d

down:
	docker compose down

restart:
	docker compose down && docker compose up -d

bash:
	docker exec -it hris_app bash

artisan:
	docker exec -it hris_app php artisan $(cmd)

migrate:
	docker exec -it hris_app php artisan migrate

composer:
	docker exec -it hris_app composer $(cmd)

npm:
	docker exec -it hris_app npm $(cmd)

install-laravel:
	docker exec -it hris_app composer create-project laravel/laravel .

permissions:
	sudo chown -R $$(id -u):$$(id -g) src
	sudo chmod -R 775 src/storage src/bootstrap/cache

logs:
	docker logs -f hris_app

ps:
	docker ps

fresh:
	docker compose down -v

backup:
	docker exec hris_mysql sh -c 'exec mysqldump -u root -p"root" hrisdb' > backup.sql

restore:
	cat backup.sql | docker exec -i hris_mysql sh -c 'mysql -u root -p"root" hrisdb'