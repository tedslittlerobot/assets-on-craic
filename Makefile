REPORT_DIR=./report

test:
	@./vendor/bin/phpunit -v

coverage: clean-test
	@./vendor/bin/phpunit --coverage-html $(REPORT_DIR)

clean-test:
	rm -rf report
