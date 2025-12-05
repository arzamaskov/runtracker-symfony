# RunTracker

[![CI](https://github.com/arzamaskov/runtracker-symfony/actions/workflows/ci.yml/badge.svg)](https://github.com/arzamaskov/runtracker-symfony/actions/workflows/ci.yml)
[![Tests](https://github.com/arzamaskov/runtracker-symfony/actions/workflows/ci.yml/badge.svg?branch=main)](https://github.com/arzamaskov/runtracker-symfony/actions/workflows/ci.yml)
[![Version](https://img.shields.io/github/v/tag/arzamaskov/runtracker-symfony?label=version&sort=semver)](https://github.com/arzamaskov/runtracker-symfony/releases)

Приложение для отслеживания беговых тренировок.

## Технологии

- **Backend**: Symfony 7.4, PHP 8.4, PostgreSQL 16
- **Frontend**: SvelteKit, TypeScript, Tailwind CSS
- **Инфраструктура**: Docker, GitHub Actions, GitHub Container Registry

## Архитектура и стандарты

### Архитектурные принципы

Проект использует **чистую гексагональную архитектуру** (Hexagonal Architecture) в сочетании с **Domain-Driven Design (DDD)**:

- **Domain Layer** — бизнес-логика и доменные сущности, не зависит от инфраструктуры
- **Application Layer** — use cases и обработчики команд/запросов (CQRS)
- **Infrastructure Layer** — реализация портов (репозитории, внешние сервисы)
- **Presentation Layer** — контроллеры, консольные команды

Архитектура организована по **Bounded Contexts** (модулям):
- `Identity` — управление пользователями и аутентификация
- `Shared` — общие компоненты (команды, запросы, исключения)

Зависимости между слоями контролируются автоматически через **Deptrac**.

### Инструменты качества кода

- **PHP CS Fixer** — проверка и автоматическое исправление стиля кода
- **PHPStan** (level 5) — статический анализ кода для выявления ошибок
- **Deptrac** — проверка соответствия архитектурным правилам и зависимостей между слоями
- **PHPUnit** — unit и интеграционные тесты

### Стандарты кода

- **PSR-12** — стандарт кодирования PHP
- **Symfony Coding Standards** — стандарты Symfony Framework
- Все комментарии и сообщения на русском языке
- Строгая типизация (`declare(strict_types=1)`)
- Коммиты в формате: `<тип>(): <описание>` на русском языке

### Локальная проверка качества кода

```bash
# Проверка стиля кода
make lint

# Автоматическое исправление стиля
make lint-fix

# Статический анализ
make stan

# Проверка архитектуры
make deptrac

# Запуск всех проверок
make ci
```

## Разработка

### Требования

- Docker и Docker Compose
- Make
- PHP 8.4+ (для локальной разработки)
- Node.js 22+ и pnpm (для локальной разработки)

### Запуск проекта

```bash
# Сборка и запуск контейнеров
make build
make up

# Подключение к контейнеру PHP
make shell

# Запуск тестов
make test

# Проверка качества кода
make ci
```

### Структура проекта

```
.
├── backend/           # Symfony приложение
├── frontend/          # SvelteKit приложение
├── docker/            # Docker конфигурации
│   ├── php/          # PHP-FPM Dockerfile
│   └── frontend/     # Frontend build Dockerfile
└── .github/
    └── workflows/    # GitHub Actions workflows
```

## Git Workflow

### Ветки

- **`main`** — основная ветка, всегда в стабильном состоянии
- **`feature/*`** — ветки для разработки новых функций

### Процесс разработки

1. **Создание feature ветки**:
```bash
git checkout -b feature/название-функции
```

2. **Разработка и коммиты**:
   - Перед каждым коммитом запускайте проверки:
   ```bash
   make lint    # Проверка стиля кода
   make stan    # Статический анализ
   ```
   - Формат коммитов: `<тип>(): <описание>` на русском языке
   - Примеры типов: `feat`, `fix`, `refactor`, `docs`, `test`, `chore`

3. **Создание Pull Request**:
   - Создайте PR из `feature/*` в `main`
   - CI автоматически запустит все проверки
   - После успешного прохождения CI и code review — мердж в `main`

4. **Релиз**:
   - После мерджа в `main` создайте тег для деплоя:
   ```bash
   git tag v1.0.0
   git push origin v1.0.0
   ```

### Формат коммитов

```
<тип>(): <описание>
```

**Типы коммитов:**
- `feat()` — новая функциональность
- `fix()` — исправление бага
- `refactor()` — рефакторинг кода
- `docs()` — изменения в документации
- `test()` — добавление или изменение тестов
- `chore()` — рутинные задачи (обновление зависимостей, конфигурации)
- `perf()` — улучшение производительности
- `style()` — изменения форматирования (не влияющие на логику)
- `config()` — изменения конфигурации

**Примеры:**
```
feat(identity): добавлена регистрация пользователя
fix(auth): исправлена валидация email
refactor(domain): упрощена структура User entity
docs(readme): обновлена документация по деплою
```

## CI/CD

Проект использует GitHub Actions для автоматизации процессов разработки и деплоя.

### Workflows

#### 1. CI (Continuous Integration)

**Триггер**: Push на любую ветку, Pull Request в main

**Проверки Backend**:
- Установка зависимостей (Composer)
- Проверка стиля кода (PHP CS Fixer)
- Статический анализ (PHPStan)
- Запуск тестов (PHPUnit)

**Проверки Frontend**:
- Установка зависимостей (pnpm)
- Проверка типов и линтинг (svelte-check)
- Сборка приложения

#### 2. CD (Continuous Deployment)

**Триггер**: Создание git тега (например, `v1.0.0`)

**Действия**:
- Сборка Docker образа для backend (app)
- Сборка Docker образа для frontend + nginx (web)
- Публикация образов в GitHub Container Registry с тегом версии
- Автоматический деплой на production сервер

**Теги образов**:
- `app-<version>` / `web-<version>` - при создании git тега
- `app-<git-sha>` / `web-<git-sha>` - образы по commit SHA

### Создание релиза

Для создания нового релиза:

```bash
# Создайте и запушьте тег
git tag v1.0.0
git push origin v1.0.0
```

Workflow автоматически соберет и опубликует Docker образы с тегом `v1.0.0` и задеплоит приложение на production сервер.

## Лицензия

Proprietary
