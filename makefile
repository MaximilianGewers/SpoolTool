APP_CONTAINER := php

exec = docker compose exec $(APP_CONTAINER)

.PHONY: up down bash migrate-generate migrate-execute

help:
	@echo "Available commands:"
	@grep -E '^[a-zA-Z0-9_-]+:' $(MAKEFILE_LIST) \
		| grep -v '^\.PHONY' \
		| sed 's/:.*//' \
		| sort \
		| sed 's/^/  /'

up:
	docker compose up -d

down:
	docker compose down

bash:
	$(exec) bash

drop-database:
	$(exec) php bin/console doctrine:database:drop --if-exists --force

create-database:
	$(exec) php bin/console doctrine:database:create --if-not-exists

migrate-generate:
	$(exec) php bin/console make:migration

migrate-execute:
	$(exec) php bin/console doctrine:migrations:migrate --no-interaction

database:
	make drop-database create-database migrate-execute