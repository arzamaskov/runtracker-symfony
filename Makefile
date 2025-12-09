.PHONY: help build up down restart logs shell shell-frontend composer pnpm console migrate test lint lint-fix lint-frontend lint-frontend-fix stan

# Цвета для вывода
GREEN  := \033[0;32m
YELLOW := \033[0;33m
RED    := \033[0;31m
NC     := \033[0m

# Пользователь для выполнения команд в контейнере
USER_ID ?= 1000
GROUP_ID ?= 1000
EXEC_USER := -u $(USER_ID):$(GROUP_ID)

# Docker Compose команды
DC := docker compose
DC_EXEC := $(DC) exec $(EXEC_USER)
DC_EXEC_ROOT := $(DC) exec -u root

# PostgreSQL
DB_USERNAME := app
DB_PASSWORD := app_password
DB_DATABASE := runtracker
DB_DATABASE_TEST := $(DB_DATABASE)_test

help: ## Показать эту справку
	@echo "$(GREEN)Доступные команды:$(NC)"
	@grep -E '^[a-zA-Z_-]+:.*?## .*$$' $(MAKEFILE_LIST) | sort | awk 'BEGIN {FS = ":.*?## "}; {printf "  $(YELLOW)%-20s$(NC) %s\n", $$1, $$2}'

# ============================================
# Docker команды
# ============================================

build: ## Собрать Docker образы
	$(DC) build --no-cache

up: ## Запустить все контейнеры
	$(DC) up -d

down: ## Остановить все контейнеры
	$(DC) down

restart: ## Перезапустить все контейнеры
	$(DC) restart

# ============================================
# Shell доступ
# ============================================

shell: ## Подключиться к контейнеру PHP
	$(DC_EXEC) php sh

shell-frontend: ## Подключиться к контейнеру Frontend
	$(DC) exec frontend sh

# ============================================
# База данных (PostgreSQL)
# ============================================

psql: ## Подключиться к PostgreSQL консоли
	$(DC) exec postgres psql -U $(DB_USERNAME) -d $(DB_DATABASE)

# ============================================
# Тестирование
# ============================================

test: ## Запустить все тесты
	$(DC_EXEC) php php bin/phpunit

test-unit: ## Запустить unit тесты
	$(DC_EXEC) php php bin/phpunit --testsuite=unit

test-integration: ## Запустить интеграционные тесты
	$(DC_EXEC) php php bin/phpunit --testsuite=integration

test-coverage: ## Запустить тесты с покрытием
	$(DC_EXEC) php php bin/phpunit --coverage-html coverage

test-filter: ## Запустить конкретный тест (make test-filter FILTER="TestName")
	$(DC_EXEC) php php bin/phpunit --filter=$(FILTER)

# ============================================
# Качество кода
# ============================================

lint: ## Проверить код на соответствие стандартам (PHP CS Fixer)
	$(DC_EXEC) php ./vendor/bin/php-cs-fixer fix --dry-run --diff --verbose

lint-fix: ## Автоматически исправить стиль кода (PHP CS Fixer)
	$(DC_EXEC) php ./vendor/bin/php-cs-fixer fix

deptrac: ## Проверить код на соответствие архитектурным стандартам
	$(DC_EXEC) php ./vendor/bin/deptrac --config-file=deptrac.yml

stan: ## Запустить статический анализ кода (PHPStan)
	$(DC_EXEC) php ./vendor/bin/phpstan analyse src tests --memory-limit=2G

# ============================================
# Frontend качество кода
# ============================================

lint-frontend: ## Проверить код фронтенда (ESLint + Prettier)
	$(DC) exec frontend pnpm lint

lint-frontend-fix: ## Автоматически исправить код фронтенда
	$(DC) exec frontend pnpm lint:fix

format-frontend: ## Форматировать код фронтенда (Prettier)
	$(DC) exec frontend pnpm format

check-frontend: ## Проверить типы TypeScript/Svelte (svelte-check)
	$(DC) exec frontend pnpm check

ci: lint deptrac stan test ## Комбо для локальной проверки перед git push

ci-frontend: check-frontend lint-frontend ## Комбо для проверки фронтенда
