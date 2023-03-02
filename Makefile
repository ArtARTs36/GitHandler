.PHONY: docs

check:
	composer lint
	composer stat-analyse
	composer test
	composer mutate-test

docs:
	composer check-docs-actual
