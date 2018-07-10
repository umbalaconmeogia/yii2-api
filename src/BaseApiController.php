<?php
namespace umbalaconmeogia\yii2api;

use common\models\ApiAuth;
use yii\filters\auth\HttpBasicAuth;
use yii\rest\ActiveController;

class BaseApiController extends ActiveController
{
    public $syncDataParam;

    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['authenticator'] = [
            'class' => HttpBasicAuth::className(),
            'auth' => [$this, 'basicAuth'],
        ];
        return $behaviors;
    }

    public function basicAuth($username, $password)
    {
        return ApiAuth::findAllowClient($username, $password);
    }

    public function actions()
    {
        $actions = parent::actions();
        $actions['sync-data'] = [
            'class' => 'umbalaconmeogia\yii2api\SyncDataAction',
            'modelClass' => $this->modelClass,
            'syncDataParam' => $this->syncDataParam,
            'checkAccess' => [$this, 'checkAccess'],
        ];
        return $actions;
    }
}