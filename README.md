# yii2-api
Helper classes to create RESTful API in yii2.

## Installation

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run
```shell
$ composer require umbalaconmeogia/yii2-api "@dev"
```

or add
```javascript
"umbalaconmeogia/yii2-api": "@dev"
```
to the require section of your composer.json file and run `composer update`.

## Add SubSystemUser

For client system that use SubSystemUser, you should run migration to create sub_system_user table.

You can add migration namespace to config as following.

For yii2 advanced template, add to *console/config/main.php*
```php
    'controllerMap' => [
        'migrate' => [
            'class' => 'yii\console\controllers\MigrateController',
            'migrationPath' => null, // disable non-namespaced migrations if app\migrations is listed below
            'migrationNamespaces' => [
                'console\migrations', // Common migrations for the whole application
                'umbalaconmeogia\yii2api\migrations', // Migrations for the specific extension
            ],
        ],
    ],
```