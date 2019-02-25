<?php
namespace umbalaconmeogia\yii2api\controllers;

use umbalaconmeogia\yii2api\models\ConsumerApiAuth;
use yii\filters\AccessControl;
use yii\filters\auth\HttpBasicAuth;
use yii\rest\ActiveController;

class BaseApiController extends ActiveController
{
    public $syncDataParam;

    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['rateLimiter']['enableRateLimitHeaders'] = false;
        $behaviors['authenticator'] = [
            'class' => HttpBasicAuth::className(),
            'auth' => [$this, 'basicAuth'],
        ];
        $behaviors['access'] = [
            'class' => AccessControl::className(),
            'rules' => [
                [
                    'allow' => true,
                    'roles' => ['@'],
                    'ips' => $this->allowedAccessIPs(),
                ],
            ],
        ];
        return $behaviors;
    }

    /**
     * Limit accessible IPs.
     * Subclass may overwrite this function to allow another IPs.
     * @return string[]
     */
    protected function allowedAccessIPs()
    {
        return ['127.0.0.1', '::1'];
    }

    /**
	 * Basic authenticate.
     * @param string $username
     * @param string $password
     * @return \yii\web\IdentityInterface
     */
    public function basicAuth($username, $password)
    {
        \Yii::trace(__METHOD__ . "($username, $password)", __METHOD__);
        return ConsumerApiAuth::findAllowClient($username, $password);
    }

    /**
     * Add sync-data action,
     * {@inheritDoc}
     * @see \yii\rest\ActiveController::actions()
     */
    public function actions()
    {
        $actions = parent::actions();
        $actions['sync-data'] = [
            'class' => \umbalaconmeogia\yii2api\actions\SyncDataAction::class,
            'modelClass' => $this->modelClass,
            'syncDataParam' => $this->syncDataParam,
            'checkAccess' => [$this, 'checkAccess'],
        ];
        return $actions;
    }
}