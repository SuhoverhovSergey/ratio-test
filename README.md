Yii 2 Test
============================

Установка
-------------------

Выполнить команду в корне проекта:

```
composer install
php yii migrate/up
```

Добавить локальный файл конфигурации `config/db-local.php` и настроить соединение с БД.

Пример содержимого файла:

```php
return [
    'dsn' => 'mysql:host=localhost;dbname=ratio-test',
    'username' => 'root',
    'password' => 'root',
];
```

Для тестов добавить локальный файл конфигурации `tests/codeception/config/config-local.php` и настроить соединение с БД.

Пример содержимого файла:

```php
return [
    'components' => [
        'db' => [
            'dsn' => 'mysql:host=localhost;dbname=ratio-test-tests',
            'username' => 'root',
            'password' => 'root',
        ],
    ],
];
```

Запуск
-------------------

Выполнить комадну:

```
php yii task
```
