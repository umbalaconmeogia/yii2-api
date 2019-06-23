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

### Configuring migration path.

```php
'migrate' => [
	'class' => 'yii\console\controllers\MigrateController',
	'migrationPath' => [
		'@console/migrations',
		'@vendor/umbalaconmeogia/yii2-api/src/migrations',
	],
],
```

### Namespaced Migrations

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

For yii2 basic template, add to *app/config/web.php*
```php
'controllerMap' => [
	'migrate' => [
		'class' => 'yii\console\controllers\MigrateController',
		'migrationPath' => null, // disable non-namespaced migrations if app\migrations is listed below
		'migrationNamespaces' => [
			'app\migrations', // Common migrations for the whole application
			'umbalaconmeogia\yii2api\migrations', // Migrations for the specific extension
		],
	],
],
```

## License

**yii2-api** is released under the MIT License. See the bundled `LICENSE` for details.