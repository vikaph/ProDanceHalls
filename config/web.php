<?php

$params = require __DIR__ . '/params.php';
$db = require __DIR__ . '/db.php';

$config = [
    'id' => 'basic',
    'name' => 'ProDance Halls',
    'language' => 'ru-RU',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm' => '@vendor/npm-asset',
    ],
    'modules' => [
        'gridview' => [
            'class' => '\kartik\grid\Module',
        ],
    ],
    'components' => [
        'request' => [
            'cookieValidationKey' => 'vdbbvdbjkdjvkknjv',
            'parsers' => [
                'application/json' => 'yii\web\JsonParser',
                'multipart/form-data' => 'yii\web\MultipartFormDataParser',
            ],
            'enableCsrfValidation' => false, // Отключаем CSRF для API
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'user' => [
            'identityClass' => 'app\models\Users',
            'enableAutoLogin' => false,
            'loginUrl' => null,
        ],
        'response' => [
            'format' => yii\web\Response::FORMAT_JSON,
            'charset' => 'UTF-8',
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'mailer' => [
            'class' => \yii\symfonymailer\Mailer::class,
            'viewPath' => '@app/mail',
            'useFileTransport' => true,
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'db' => $db,

        // JWT компонент (для авторизации)
        'jwt' => [
            'class' => \app\components\JwtHelper::class,
            'key' => 'pohodilova-secret-key-2025-booking-halls', // секретный ключ
        ],

        'urlManager' => [
            'enablePrettyUrl' => true,
            'enableStrictParsing' => true,
            'showScriptName' => false,
            'rules' => [
                // ===== Главная страница =====
                '' => 'site/index',
                
                // ===== Пользователь =====
                'POST api/register' => 'api/user/create',
                'POST api/login' => 'api/user/login',
                'POST api/profile/avatar' => 'api/user/upload-avatar',
                'GET api/profile' => 'api/user/profile',

                // ===== Залы =====
             [
    'class' => 'yii\rest\UrlRule',
    'controller' => ['api/halls' => 'api/hall'],
    'pluralize' => false,
             ],
                'POST api/halls/<id:\d+>/photo' => 'api/hall/upload-photo',
                'GET api/halls/<id:\d+>/available-slots' => 'api/hall/available-slots',

                // ===== Бронирования =====
                ['class' => 'yii\rest\UrlRule', 'controller' => ['api/bookings' => 'api/booking'], 'pluralize' => false],

                // ===== Админ бронирования =====
        
'POST api/admin/bookings/<id:\d+>/approve' => 'api/booking/approve',
'DELETE api/admin/bookings/<id:\d+>' => 'api/booking/admin-delete',


                // ===== Админ категории =====
                ['class' => 'yii\rest\UrlRule', 'controller' => ['api/admin/categories' => 'api/admin/category'], 'pluralize' => false],

                // ===== Админ пользователи =====
                ['class' => 'yii\rest\UrlRule', 'controller' => ['api/admin/users' => 'api/admin/user'], 'pluralize' => false],
                'POST api/admin/users/<id:\d+>/block' => 'api/admin/user/block',
                'POST api/admin/users/<id:\d+>/unblock' => 'api/admin/user/unblock',
            ],
        ],
    ],
    'params' => $params,
];

if (YII_ENV_DEV) {
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
        'allowedIPs' => ['*'],
    ];
}

return $config;
