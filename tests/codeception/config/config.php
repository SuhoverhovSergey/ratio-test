<?php
/**
 * Application configuration shared by all test types
 */
$config = [
    'language' => 'en-US',
    'controllerMap' => [
        'fixture' => [
            'class' => 'yii\faker\FixtureController',
            'fixtureDataPath' => '@tests/codeception/fixtures',
            'templatePath' => '@tests/codeception/templates',
            'namespace' => 'tests\codeception\fixtures',
        ],
    ],
    'aliases' => [
        'Plp' => dirname(dirname(dirname(__DIR__))) . '/Plp',
    ],
    'components' => [
        'db' => [
            'dsn' => 'mysql:host=localhost;dbname=yii2_basic_tests',
        ],
        'mailer' => [
            'useFileTransport' => true,
        ],
        'urlManager' => [
            'showScriptName' => true,
        ],
    ],
];

return yii\helpers\ArrayHelper::merge(
    $config,
    require(__DIR__ . '/config-local.php')
);
