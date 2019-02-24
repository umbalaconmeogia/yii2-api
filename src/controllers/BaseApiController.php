<?php
namespace umbalaconmeogia\yii2api\controllers;

use yii\filters\AccessControl;
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
     * Sub class should implement this function to check basic authentication from input username and password.
     *
     * @param string $username
     * @param string $password
     * @return \yii\web\IdentityInterface
     */
    public function basicAuth($username, $password)
    {
        throw new \Exception(__METHOD__ . ' is not implemented.');
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