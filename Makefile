build:
		docker-compose build
		composer install -d ./AllWeShare

start:
		docker-compose up -d --build
		yarn --cwd ./AllWeShare install
		yarn --cwd ./AllWeShare encore dev

down:
		docker-compose down

bash:
		docker exec -it allweshare_php-fpm_1 bash

dev:	build start bash