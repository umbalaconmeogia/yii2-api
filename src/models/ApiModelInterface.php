<?php
namespace umbalaconmeogia\yii2api\models;

interface ApiModelInterface
{
    /**
     * Usage
     * <pre>
     * public function rules()
     * {
     *     return [
     *         [['username', 'auth_key', 'data_status'], 'safe', 'on' => self::SCENARIO_SYNC_DATA],
     *     ];
     * }
     * </pre>
     * or
     * <pre>
     * public function scenarios()
     * {
     *     return [
     *         ApiModelInterface::SCENARIO_SYNC_DATA => ['username', 'auth_key', 'data_status'],
     *     ];
     * }
     * </pre>
     *
     * @var string
     */
    const SCENARIO_SYNC_DATA = 'syncData';
}