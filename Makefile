parameters:
		cp app/config/parameters.yml.dist app/config/parameters.yml

local-composer:
		composer install -n --no-scripts

up:
		docker-compose up -d --build

install-db:
		docker-compose exec php bin/console doctrine:schema:create

run: parameters local-composer up install-db

pull-eth:
		docker-compose exec php bin/console app:pull-coin-snapshot ETH
