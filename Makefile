include .env
export

# COLORS
GREEN  := $(shell tput -Txterm setaf 2)
YELLOW := $(shell tput -Txterm setaf 3)
RESET  := $(shell tput -Txterm sgr0)

help:
	@echo ''
	@echo 'Utilisation :'
	@echo '  ${YELLOW}make${RESET} ${GREEN}<command>${RESET}'
	@echo ''
	@echo 'Commandes :'
	@awk '/^[a-zA-Z\-\_0-9]+:/ { \
		helpMessage = match(lastLine, /^## (.*)/); \
		if (helpMessage) { \
			helpCommand = substr($$1, 0, index($$1, ":")-1); \
			helpMessage = substr(lastLine, RSTART + 3, RLENGTH); \
			printf "  ${YELLOW}%-$(TARGET_MAX_CHAR_NUM)s${RESET} ${GREEN}%s${RESET}\n", helpCommand, helpMessage; \
		} \
	} \
	{ lastLine = $$0 }' $(MAKEFILE_LIST)

## démarrage des containers
start:
	@chmod +x ./docker/php/entrypoint.sh
	@envsubst '$$APP_NAME' < ./docker/web/default.conf.tpl > ./docker/web/default.conf
	@docker compose up

## Fermeture des containers
stop:
	@docker compose down

## Fermeture et redémarrage des containers
restart: stop start

## Nettoyage complet des données liées à docker
prune:
	@docker compose down
	@docker system prune -a

## Execution de la commande "composer install"
composer-install:
	@docker compose exec php bash -c "\
		cd /home/${APP_NAME} && composer install"

## Ouverture d'un bash dans le container php
bash-php:
	@docker compose exec -w "/home/${APP_NAME}" php sh

## Ouverture d'un bash dans le container web
bash-web:
	@docker compose exec web sh