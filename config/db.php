<?php

$dbConfig = [
    'class' => 'yii\db\Connection',
    'dsn' => 'mysql:host=localhost;dbname=yii2basic',
    'username' => 'root',
    'password' => '',
    'charset' => 'utf8',
];

return yii\helpers\ArrayHelper::merge(
    $dbConfig,
    require(__DIR__ . '/db-local.php')
);
