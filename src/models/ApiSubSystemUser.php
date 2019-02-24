<?php
namespace api\models;

use common\models\SubSystemUser;
use umbalaconmeogia\yii2api\models\ApiModelInterface;

class ApiSubSystemUser extends SubSystemUser implements \umbalaconmeogia\yii2api\models\ApiModelInterface, \yii\filters\RateLimitInterface
{
    public $rateLimit = 1;
    public $allowance;
    public $allowance_updated_at;

    public function scenarios()
    {
        return [
            ApiModelInterface::SCENARIO_SYNC_DATA => ['username', 'auth_key', 'data_status'],
        ];
    }

    /**
     * {@inheritDoc}
     * @see \yii\filters\RateLimitInterface::getRateLimit()
     */
    public function getRateLimit($request, $action) {
        return [$this->rateLimit, 1];
    }

    /**
     * {@inheritDoc}
     * @see \yii\filters\RateLimitInterface::loadAllowance()
     */
    public function loadAllowance($request, $action)
    {
        return [$this->allowance, $this->allowance_updated_at];
    }

    /**
     * {@inheritDoc}
     * @see \yii\filters\RateLimitInterface::saveAllowance()
     */
    public function saveAllowance($request, $action, $allowance, $timestamp)
    {
        $this->allowance = $allowance;
        $this->allowance_updated_at = $timestamp;
        $this->save();
    }
}