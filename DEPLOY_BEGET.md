# Deploy На Beget

## Что уже подготовлено

- production-шаблон окружения: [.env.beget.example](/d:/ilnz-main/ilnz-main/.env.beget.example:1)
- fallback для `public_html`, если на Beget нельзя поставить корень сайта на `public`:
  - [tools/deploy/beget/public_html/index.php](/d:/ilnz-main/ilnz-main/tools/deploy/beget/public_html/index.php:1)
  - [tools/deploy/beget/public_html/.htaccess](/d:/ilnz-main/ilnz-main/tools/deploy/beget/public_html/.htaccess:1)

## Рекомендуемый вариант

Лучше всего в панели Beget указать корень сайта на папку `public`.

Тогда структура на хостинге должна быть такой:

```text
/home/LOGIN/project
  app
  bootstrap
  config
  database
  public
  resources
  routes
  storage
  vendor
  artisan
  .env
```

## Вариант если нельзя поставить корень на `public`

Тогда:

1. Загружаете весь проект в папку сайта, например `~/carhut`.
2. Содержимое папки `tools/deploy/beget/public_html/` копируете в `public_html`.
3. Содержимое папки `public/` тоже копируете в `public_html`, кроме `index.php` и `.htaccess`, потому что их уже заменит fallback-версия.

В fallback-файле `index.php` проект ожидается на уровень выше `public_html`.

## Что заливать

Обязательно:

- `app`
- `bootstrap`
- `config`
- `database`
- `public`
- `resources`
- `routes`
- `storage`
- `vendor`
- `artisan`
- `composer.json`
- `composer.lock`
- `.env`

Не нужно заливать:

- `.git`
- локальные временные файлы
- `.phpunit.result.cache`
- документы и учебные артефакты

## Настройка `.env`

1. Возьмите [.env.beget.example](/d:/ilnz-main/ilnz-main/.env.beget.example:1)
2. Сохраните как `.env`
3. Заполните:

```env
APP_URL=https://ваш-домен.ru
DB_DATABASE=имя_базы
DB_USERNAME=пользователь_базы
DB_PASSWORD=пароль_базы
```

4. После загрузки выполните:

```bash
php artisan key:generate
```

## Команды после загрузки

Если есть SSH:

```bash
composer install --no-dev --optimize-autoloader
php artisan key:generate
php artisan migrate --force
php artisan storage:link
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

## Что важно для этого проекта

- локально проект работает на `sqlite`, на Beget лучше использовать `mysql`
- изображения каталога уже лежат в `public/images/cars`
- пользовательские загрузки тоже важны: `public/uploads/cars`
- директории `storage` и `bootstrap/cache` должны быть доступны на запись

## Проверка после деплоя

Проверь:

1. Открывается главная
2. Открывается каталог
3. Работает вход в админку
4. Создаётся объявление
5. Загружаются картинки
6. Работают избранное и сообщения

## Если будет 500 ошибка

Проверь по порядку:

1. Версия PHP на Beget: нужна `8.1+`, лучше `8.2` или `8.3`
2. Заполнен ли `.env`
3. Сгенерирован ли `APP_KEY`
4. Выполнены ли миграции
5. Есть ли права на `storage` и `bootstrap/cache`
6. Точно ли веб-корень смотрит в `public` или настроен fallback через `public_html`
