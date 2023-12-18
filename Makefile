export UID := $(shell id -u)
export GID := $(shell id -g)

project-init:
	echo "Creating hooks"
	rm -f .git/hooks/pre-commit
	ln -s ../../hooks/pre-commit .git/hooks/pre-commit

build:
	docker compose build
up:
	docker compose up
down:
	docker compose down
bash:
	docker compose exec php bash

