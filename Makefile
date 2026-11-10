help:
	@echo "\nToDo\n"
	@echo "=========================================================================================="
	@echo "make build"
	@echo "make install"
	@echo "make test"
	@echo "\n----------------------------------------------------------------------------------------"

install:
	cd application && composer install
build:
	cd docker && cp -n .env.dist .env || true
	cd docker && docker-compose up -d
test:
	cd application && ./bin/phpunit tests
