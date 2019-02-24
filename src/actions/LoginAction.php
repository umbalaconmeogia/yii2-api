<?php
namespace umbalaconmeogia\yii2api\actions;

use yii\base\Model;
use yii\rest\Action;
use yii\web\UnauthorizedHttpException;

/**
 * SyncDataAction implements the API endpoint for synchronizing data from the given data.
 *
 * For more details and usage information on SyncDataAction, see the [guide article on rest controllers](guide:rest-controllers).
 *
 * @author Tran Trung Thanh <umbalaconmeogia@gmail.com>
 */
class LoginAction extends Action
{
    /**
     * @var string the scenario to be assigned to the new model before it is validated and saved.
     */
    public $scenario = Model::SCENARIO_DEFAULT;

    /**
     * Creates a new model.
     * @return \yii\db\ActiveRecordInterface the model newly created
     */
    public function run()
    {
        $result = NULL;

        $request = \Yii::$app->request;
        $username = $request->getBodyParam('username');
        $password = $request->getBodyParam('password');
        $user = $this->modelClass::findByUsername($username);
        if ($user && $user->validatePassword($password)) {
            $result = $user;
        } else {
            throw new UnauthorizedHttpException();
        }

        return $result;
    }
}
