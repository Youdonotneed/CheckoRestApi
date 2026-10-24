# REST API для Checko.ru

Тестовое задание: разработка REST API на чистом PHP в стиле ООП для получения данных с ресурса [Checko.ru](https://checko.ru/).

## Архитектура
* **Язык:** PHP 8.4
* **Веб-сервер:** PHP-сервер
* **Зависимости:** Composer
* **Обработка ошибок:** Кастомные исключения (`\Exception`).

## Структура
* `public/index.php` — точка входа, инициализация приложения.
* `src/Router.php` — роутинг запросов.
* `src/Controller/CompanyController.php` — контроллер, принимает запросы.
* `src/Service/CompanyClient.php` — клиент для взаимодействия с API Checko через cURL.
* `.env` — конфигурация (ключ API).
* `.env.example` — шаблон конфигурации.