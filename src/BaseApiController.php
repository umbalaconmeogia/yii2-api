<?php
namespace umbalaconmeogia\yii2api;

use yii\filters\auth\HttpBasicAuth;
use yii\rest\ActiveController;
use yii\web\IdentityInterface;

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

    /**
     * Sub class should implement this function to check basic authentication from input username and password.
     *
     * @param string $username
     * @param string $password
     * @return IdentityInterface
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
            'class' => SyncDataAction::class,
            'modelClass' => $this->modelClass,
            'syncDataParam' => $this->syncDataParam,
            'checkAccess' => [$this, 'checkAccess'],
        ];
        return $actions;
    }
}