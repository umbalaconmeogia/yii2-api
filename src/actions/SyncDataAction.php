<?php
namespace umbalaconmeogia\yii2api\actions;

use umbalaconmeogia\yii2api\models\ApiModelInterface;
use yii\rest\Action;

/**
 * SyncDataAction implements the API endpoint for synchronizing data from the given data.
 *
 * For more details and usage information on SyncDataAction, see the [guide article on rest controllers](guide:rest-controllers).
 *
 * @author Tran Trung Thanh <umbalaconmeogia@gmail.com>
 */
class SyncDataAction extends Action
{
    /**
     * @var string the scenario to be assigned to the new model before it is validated and saved.
     */
    public $keyField = 'id';

    /**
     * Name of parameter that provides data for upadte.
     * This name is corresponding to the base model class of the DB table.
     * For example, "User" for sync-data for user data.
     *
     * Normaly, the variable's value is specified in controller class,
     * and is passed to SyncDataAction via controller's actions() method.
     * @var string
     */
    public $syncDataParam;

    /**
     * Creates a new model.
     * @return \yii\db\ActiveRecordInterface the model newly created
     */
    public function run()
    {
        if ($this->checkAccess) {
            call_user_func($this->checkAccess, $this->id);
        }

        $modelArrays = \Yii::$app->request->getBodyParam($this->syncDataParam);
        \Yii::trace("Data: " . print_r($modelArrays, TRUE), __METHOD__);
        foreach ($modelArrays as $modelAttributes) {
            $model = $this->modelClass::findOneCreateNew([$this->keyField => $modelAttributes[$this->keyField]]);
            $model->scenario = ApiModelInterface::SCENARIO_SYNC_DATA;
            unset($modelAttributes[$this->keyField]); // This is for Yii not raise warning "Failed to set unsafe attribute 'id'"
            $model->attributes = $modelAttributes;
            $model->saveThrowError();
        }
    }
}
