.PHONY: init thumbor-server php-server

init: thumbor-server php-server

php-server:
	php -S localhost:8000 -t public

thumbor-server:
	thumbor -c api/data/thumbor.conf
