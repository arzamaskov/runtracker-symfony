# RunTracker

Приложение для отслеживания беговых тренировок.

## Технологии

- **Backend**: Symfony 7.4, PHP 8.4, PostgreSQL 16
- **Frontend**: SvelteKit, TypeScript, Tailwind CSS
- **Инфраструктура**: Docker, GitHub Actions, GitHub Container Registry

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

#### 2. Build (Сборка Docker образов)

**Триггер**: Push в main, создание тегов

**Действия**:
- Сборка Docker образа для backend (app)
- Сборка Docker образа для frontend + nginx (web)
- Публикация образов в GitHub Container Registry

**Теги образов**:
- `app-<git-sha>` / `web-<git-sha>` - образы по commit SHA
- `app-latest` / `web-latest` - последние образы из main
- `app-<version>` / `web-<version>` - при создании git тега

#### 3. Deploy to Production

**Триггер**: Создание git тега (например, `v1.0.0`)

**Процесс деплоя**:
1. Подключение к production серверу по SSH
2. Обновление `docker-compose.production.yml` с новыми тегами образов
3. Pull новых Docker образов
4. Остановка и удаление старых контейнеров
5. Запуск новых контейнеров
6. Применение миграций БД
7. Очистка и прогрев кеша
8. Перезапуск queue worker
9. Проверка статуса контейнеров

### Создание релиза

Для создания нового релиза и автоматического деплоя на production:

```bash
# Создайте и запушьте тег
git tag v1.0.0
git push origin v1.0.0
```

Workflow автоматически:
1. Соберет и опубликует Docker образы с тегом `v1.0.0`
2. Задеплоит приложение на production сервер

### Настройка GitHub Secrets

Для работы CI/CD необходимо настроить следующие секреты в настройках репозитория:

| Secret | Описание |
|--------|----------|
| `GHCR_TOKEN` | Personal Access Token с правами `write:packages` |
| `GHCR_USERNAME` | Имя пользователя GitHub |
| `SSH_HOST` | IP адрес или hostname продакшен сервера |
| `SSH_PORT` | SSH порт (обычно 22) |
| `SSH_USER` | SSH пользователь |
| `SSH_KEY` | Приватный SSH ключ для доступа к серверу |

## Production Deploy

### Настройка сервера

1. **Создайте директорию проекта**:
```bash
mkdir -p /opt/run-app
cd /opt/run-app
```

2. **Скопируйте файлы конфигурации**:
   - `docker-compose.production.yml` - основная конфигурация
   - `nginx.conf` - конфигурация nginx
   - `.env` - переменные окружения (используйте `.env.production` как шаблон)

3. **Настройте переменные окружения в `/opt/run-app/.env`**:
```bash
# Скопируйте шаблон
cp .env.production .env

# Заполните значения:
# - APP_SECRET (сгенерируйте: openssl rand -hex 32)
# - DB_PASSWORD (надежный пароль для PostgreSQL)
# - JWT_PASSPHRASE (сгенерируйте JWT ключи - см. комментарии в .env)
nano .env
```

4. **Настройте nginx на хосте** для проксирования на порт 8081:
```nginx
server {
    listen 443 ssl http2;
    server_name runtracker.ru www.runtracker.ru;

    location / {
        proxy_pass http://127.0.0.1:8081;
        proxy_set_header Host $host;
        proxy_set_header X-Real-IP $remote_addr;
        proxy_set_header X-Forwarded-For $proxy_add_x_forwarded_for;
        proxy_set_header X-Forwarded-Proto https;
    }
}
```

5. **Первый запуск**:
```bash
cd /opt/run-app
docker compose -f docker-compose.production.yml up -d
docker compose -f docker-compose.production.yml exec app php bin/console doctrine:migrations:migrate
```

### Мониторинг

```bash
# Просмотр логов
docker compose -f docker-compose.production.yml logs -f

# Проверка статуса контейнеров
docker compose -f docker-compose.production.yml ps

# Перезапуск сервисов
docker compose -f docker-compose.production.yml restart
```

## Лицензия

Proprietary
