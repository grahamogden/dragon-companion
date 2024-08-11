test:
	clear && vendor/bin/phpunit

test_cov:
	clear && vendor/bin/phpunit --coverage-html tests/coverage/

test_cov_file:
	clear && vendor/bin/phpunit --coverage-html tests/coverage/ --filter StandardPolicyTraitTest::testCanViewReturnsTrueIfUserIdIsEqualToEntityUserIdWithoutPerformingOtherChecks


test_integration:
	clear && vendor/bin/phpunit -c phpunit-integration.xml

test_integration_file:
	clear && vendor/bin/phpunit -c phpunit-integration.xml --filter CampaignControllerTest

test_mutate:
	clear && vendor/bin/infection --threads=10