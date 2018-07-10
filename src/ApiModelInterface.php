<?php
namespace umbalaconmeogia\yii2api;

interface ApiModelInterface
{
    /**
     * ```
     * public function rules()
     * {
     *     return [
     *         [$this->syncDataFields(), 'safe', 'on' => self::SCENARIO_SYNC_DATA],
     *         // Another rules.
     *     ];
     * }
     * ```
     * or
     * ```
     * public function scenarios()
     * {
     *   $scenarios = parent::scenarios();
     *   $scenarios[self::SCENARIO_SYNC_DATA] = $this->syncDataFields();
     *   return $scenarios;
     * }
     * ```
     *
     * @var string
     */
    const SCENARIO_SYNC_DATA = 'syncData';

    /**
     * List of fields to be able to sync-data.
     * @return string[]
     */
    public function syncDataFields();
}