start:
	php artisan serve
test:
	php artisan test --testsuite=Feature
test-coverage:
	 php artisan test --testsuite=Feature --coverage-clover build/logs/clover.xml
deploy:
	git push heroku
lint:
	composer exec --verbose phpcs
log:
	tail -f storage/logs/laravel.log
setup:
	composer install
	cp -n .env.example .env|| true
	php artisan key:gen --ansi
	php artisan migrate
	php artisan db:seed
	npm ci
