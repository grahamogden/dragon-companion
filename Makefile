start:
	./vendor/bin/sail up -d

start_shell: start shell

start_dev: start npm_dev

shell:
	./vendor/bin/sail shell

npm_dev:
	./vendor/bin/sail npm run dev

stop:
	./vendor/bin/sail down

# Database

db_migrate:
	./vendor/bin/sail php artisan migrate

db_migrate_x:
	./vendor/bin/sail php artisan migrate --pretend

db_rollback:
	./vendor/bin/sail php artisan rollback

db_status:
	./vendor/bin/sail php artisan migrate:status