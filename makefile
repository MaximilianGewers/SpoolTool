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

migrate-generate:
	$(exec) php bin/console make:migration

migrate-execute:
	$(exec) php bin/console doctrine:migrations:migrate --no-interaction
