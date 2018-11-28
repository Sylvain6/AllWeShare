build:
		docker-compose build

start:
		docker-compose up -d

down:
		docker-compose down

bash:
		docker exec -it allweshare_php-fpm_1 bash

dev:	build start bash