pint:
	docker compose run --rm app ./vendor/bin/pint
d-build:
	docker compose build
d-up:
	docker compose up -d
d-down:
	docker compose down
d-re-up:
	docker compose down && docker compose up -d
d-migrate:
	docker compose run --rm app php artisan migrate
d-seed:
	docker compose run --rm app php artisan db:seed
d-ssh-api:
	docker exec -it code-lara /bin/bash
