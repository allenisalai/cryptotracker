up:
		docker-compose up -d --build

pull-eth:
		docker-compose exec php bin/console app:pull-coin-snapshot ETH

install-db:
		docker-compose exec php bin/console doctrine:schema:create

run: up install-db pull-eth
