test:
	vendor/bin/phpunit

test_cov:
	vendor/bin/phpunit --coverage-html tests/coverage/

test_mutate:
	vendor/bin/infection --threads=10