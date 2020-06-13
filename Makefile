include .env

up: # create and start containers
	@docker-compose -f ${DOCKER_CONFIG} up -d

down: # stop and destroy containers
	@docker-compose -f ${DOCKER_CONFIG} down

down-volume: #  WARNING: stop and destroy containers with volumes
	@docker-compose -f ${DOCKER_CONFIG} down -v

start: # start already created containers
	@docker-compose -f ${DOCKER_CONFIG} start

stop: # stop containers, but not destroy
	@docker-compose -f ${DOCKER_CONFIG} stop

ps: # show started containers and their status
	@docker-compose -f ${DOCKER_CONFIG} ps

build: # build all dockerfile, if not built yet
	@docker-compose -f ${DOCKER_CONFIG} build


connect_app : # php-fpm command line
	@docker-compose -f ${DOCKER_CONFIG} exec -u www -w /www/app php-fpm sh

connect_node: # node command line
	@docker-compose -f ${DOCKER_CONFIG} exec -u www -w /www/app node sh

connect_nginx: # nginx command line
	@docker-compose -f ${DOCKER_CONFIG} exec -w /www nginx sh

connect_db: # database command line
	@docker-compose -f ${DOCKER_CONFIG} exec db bash
connect_test_db: # database command line
	@docker-compose -f ${DOCKER_CONFIG} exec test-db bash

init:
	@docker-compose -f ${DOCKER_CONFIG} exec -u www -w /www/app php-fpm composer create-project --prefer-dist laravel/laravel .

vendor: # composer install
	@docker-compose -f ${DOCKER_CONFIG} exec -u www -w /www/app php-fpm composer install

testing: # composer install
	@docker-compose -f ${DOCKER_CONFIG} exec -u www -w /www/app php-fpm vendor/bin/phpunit


key: # gen application key
	@docker-compose -f ${DOCKER_CONFIG} exec -u www -w /www/app php-fpm php artisan key:generate

fresh: # refresh the database and run all database seeds
	@docker-compose -f ${DOCKER_CONFIG} exec -u www -w /www/app php-fpm php artisan migrate:fresh --seed

composer_dump: # composer dump-autoload
	@docker-compose -f ${DOCKER_CONFIG} exec -u www -w /www/app php-fpm composer dump-autoload

test: # run all tests
	@docker-compose -f ${DOCKER_CONFIG} exec -u www -w /www/app php-fpm php vendor/bin/phpunit

create_controller: # create controller name=[controllerName]
	@docker-compose -f ${DOCKER_CONFIG} exec -u www -w /www/app php-fpm php artisan make:controller $(name)

create_model: # create model name=[modelName]
	@docker-compose -f ${DOCKER_CONFIG} exec -u www -w /www/app php-fpm php artisan make:model Models/$(name) -m

create_seeder: # create seeder name=[seederName]
	@docker-compose -f ${DOCKER_CONFIG} exec -u www -w /www/app php-fpm php artisan make:seeder $(name)TableSeeder

create_test: # create seeder name=[seederName]
	@docker-compose -f ${DOCKER_CONFIG} exec -u www -w /www/app php-fpm php artisan make:test $(name)
