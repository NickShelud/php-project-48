install:
	composer install

lint:
	composer exec --verbose phpcs -- --standard=PSR12 src bin tests
	composer exec --verbose phpstan -- --level=8 src tests

test:
	composer exec --verbose phpunit tests

test-coverage:
	composer exec --verbose phpunit tests -- --coverage-text