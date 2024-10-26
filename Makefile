export UID := $(shell id -u)
export GID := $(shell id -g)

SHELL = /bin/bash
DOCKER_COMPOSE_EXEC =

FURTHER_ARGS :=

# Add here commands that support additional arguments
CMDS_WITH_ARGS := test
ifneq ($(filter $(firstword $(MAKECMDGOALS)),$(CMDS_WITH_ARGS)),)
  FURTHER_ARGS := $(wordlist 2,999,$(MAKECMDGOALS))
  # The args are not targets, let's make them silently fail
  $(eval $(subst :,\:,$(subst %,\%, $(FURTHER_ARGS))):;@true)
  $(eval .PHONY: $(subst :,\:, $(subst ;,\;, $(FURTHER_ARGS))))
endif

# define standard colors
ifneq (,$(findstring xterm,${TERM}))
	BLACK        := $(shell tput -Txterm setaf 0)
	RED          := $(shell tput -Txterm setaf 1)
	GREEN        := $(shell tput -Txterm setaf 2)
	YELLOW       := $(shell tput -Txterm setaf 3)
	LIGHTPURPLE  := $(shell tput -Txterm setaf 4)
	PURPLE       := $(shell tput -Txterm setaf 5)
	BLUE         := $(shell tput -Txterm setaf 6)
	WHITE        := $(shell tput -Txterm setaf 7)
	RESET := $(shell tput -Txterm sgr0)
else
	BLACK        := ""
	RED          := ""
	GREEN        := ""
	YELLOW       := ""
	LIGHTPURPLE  := ""
	PURPLE       := ""
	BLUE         := ""
	WHITE        := ""
	RESET        := ""
endif

# set target color
NOTIFICATION_COLOR := $(BLUE)

all: help
help:
	@echo "Here is a list of make commands with the corresponding description"
	@echo
	@awk 'BEGIN {FS = ":.*?## "} /^[a-zA-Z_-]+:.*?## / {printf "$(NOTIFICATION_COLOR)%-30s$(RESET) %s\n", $$1, $$2}' $(MAKEFILE_LIST)

project-init:  ## Initialize the project
	echo "Creating hooks"
	rm -f .git/hooks/pre-commit
	ln -s ../../hooks/pre-commit .git/hooks/pre-commit

build:  ## Build the project
	docker compose build
up:  ## Start the project
	docker compose up -d
down:  ## Stop the project
	docker compose down
bash:  ## Access the php container
	docker compose exec php bash
test:  ## Run the tests
	docker compose exec -it php $(SHELL) -c "vendor/bin/phpunit --colors=always --testdox $(FURTHER_ARGS)"
