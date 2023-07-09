export UID := $(shell id -u)
export GID := $(shell id -g)

build:
	docker compose build
up:
	docker compose up
down:
	docker compose down
bash:
	docker compose exec php bash

