SYMFONY  = bin/console
COMPOSER = composer

##
## Utils
## -----
##
start: ## Start the application
start:
	$(SYMFONY) server:start

db: ## Reset the database and load fixtures
db: .env vendor
	php -r 'echo "Wait database...\n"; set_time_limit(15); require __DIR__."/vendor/autoload.php"; (new \Symfony\Component\Dotenv\Dotenv())->load(__DIR__."/.env"); $$u = parse_url(getenv("DATABASE_URL")); for(;;) { if(@fsockopen($$u["host"].":".($$u["port"] ?? 3306))) { break; }}'
	-$(SYMFONY) doctrine:database:drop --if-exists --force
	-$(SYMFONY) doctrine:database:create --if-not-exists
	$(SYMFONY) doctrine:migrations:migrate --no-interaction --allow-no-migration
	$(SYMFONY) doctrine:fixtures:load --no-interaction

migration: ## Generate a new doctrine migration
migration: vendor
	$(SYMFONY) doctrine:migrations:diff

db-validate-schema: ## Validate the doctrine ORM mapping
db-validate-schema: .env vendor
	$(SYMFONY) doctrine:schema:validate

.PHONY: start db migration watch

# rules based on files
composer.lock: composer.json
	$(COMPOSER) update --lock --no-scripts --no-interaction

vendor: composer.lock
	$(COMPOSER) install

.env: .env.dist
	@if [ -f .env ]; \
	then\
		echo '\033[1;41m/!\ The .env.dist file has changed. Please check your .env file (this message will not be displayed again).\033[0m';\ # Red color then Off.
		touch .env;\
		exit 1;\
	else\
		echo cp .env.dist .env;\
		cp .env.dist .env;\
	fi
#RSA keys generation
rsa-keys: ## Generate RSA keys need for JWT encoding/decoding
rsa-keys:
	@if [ -f config/jwt/private.pem ]; \
	then\
		rm config/jwt/private.pem;\
	fi
	@if [ -f config/jwt/public.pem ]; \
	then\
		rm config/jwt/public.pem;\
	fi
	openssl genrsa -out config/jwt/private.pem -aes256 -passout pass:passphrase 4096
	openssl rsa -pubout -in config/jwt/private.pem -out config/jwt/public.pem -passin pass:passphrase

##
## Quality assurance
## -----------------
##

lint: ## Run lint check
lint:
	$(SYMFONY) lint:yaml config/
	$(SYMFONY) lint:yaml fixtures/
	$(SYMFONY) lint:yaml translations/

php-cs-fixer: ## Run php-cs-fixer
php-cs-fixer:
	$(EXEC_PHP) vendor/bin/php-cs-fixer fix --verbose

phpstan: ## Run phpstan
phpstan:
	$(EXEC_PHP) vendor/bin/phpstan analyse --level 6 src tests

security: ## Run security-checker
security:
	$(EXEC_PHP) vendor/bin/security-checker security:check

test: ## Run phpunit tests
test:
	$(EXEC_PHP) bin/phpunit

validate-composer: ## Validate composer.json and composer.lock
validate-composer:
	$(EXEC_PHP) composer validate

validate-mapping: ## Validate doctrine mapping
validate-mapping:
	$(SYMFONY) doctrine:schema:validate --skip-sync -vvv --no-interaction

.DEFAULT_GOAL := help
help:
	@grep -E '(^[a-zA-Z_-]+:.*?##.*$$)|(^##)' $(MAKEFILE_LIST) | awk 'BEGIN {FS = ":.*?## "}; {printf "\033[32m%-30s\033[0m %s\n", $$1, $$2}' | sed -e 's/\[32m##/[33m/'
.PHONY: help
