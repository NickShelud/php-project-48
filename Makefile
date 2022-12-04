install:
	composer install

lint:
	phpcs src bin

test:
	composer exec --verbose phpunit tests