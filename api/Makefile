DOCKER_COMPOSE = docker compose -f compose.yml

init:
	$(DOCKER_COMPOSE) build --pull
	$(DOCKER_COMPOSE) run --rm php-cli composer install
	$(DOCKER_COMPOSE) up -d

start:
	$(DOCKER_COMPOSE) up -d --remove-orphans --force-recreate --build

stop:
	$(DOCKER_COMPOSE) stop

down:
	$(DOCKER_COMPOSE) down

down-clear:
	$(DOCKER_COMPOSE) down -v --remove-orphans

pull:
	$(DOCKER_COMPOSE) pull

update-deps:
	$(DOCKER_COMPOSE) run --rm --no-deps php-cli composer update

psalm:
	$(DOCKER_COMPOSE) run --rm --no-deps php-cli composer run psalm -- --show-info=true

php-cs-fixer:
	$(DOCKER_COMPOSE) run --rm --no-deps php-cli composer run php-cs-fixer

rector:
	$(DOCKER_COMPOSE) run --rm --no-deps php-cli composer run rector

lint-fix: rector php-cs-fixer

test:
	$(DOCKER_COMPOSE) run --rm --no-deps php-cli composer run test

test-coverage:
	$(DOCKER_COMPOSE) run --rm --no-deps php-cli composer run test-coverage
