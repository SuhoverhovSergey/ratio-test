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
    'dsn' => 'mysql:host=localhost;dbname=test',
    'username' => 'root',
    'password' => 'root',
];
```

Запуск
-------------------

Выполнить комадну:

```
php yii task
```
