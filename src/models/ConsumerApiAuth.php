<?php
namespace umbalaconmeogia\yii2api\models;

use yii\base\NotSupportedException;
use yii\web\IdentityInterface;
use yii\base\BaseObject;

/**
 * $username and $password are set in config as below.
 * <pre>
 * $config = [
 *     'container' => [
 *         'definitions' => [
 *             'umbalaconmeogia\yii2api\models\ConsumerApiAuth' => [
 *                 'username' => 'people',
 *                 'password' => 'people-2az2',
 *             ],
 *         ],
 *     ],
 * ];
 * </pre>
 *
 */
class ConsumerApiAuth extends BaseObject implements IdentityInterface
{
    public $username;

    public $password;

    public static function findAllowClient($username, $password)
    {
        \Yii::trace(__METHOD__ . "($username, ***)", __METHOD__);
        $result = null;
        $apiAuth = \Yii::createObject(static::class); // Create object like this allow setting username and password via config.
        \Yii::trace("username = $apiAuth->username, password = ***", __METHOD__);
        if ($apiAuth->username == $username && $apiAuth->password == $password) {
            $result = $apiAuth;
        }
        return $result;
    }

    public function validateAuthKey($authKey)
    {
        throw new NotSupportedException(__METHOD__ . ' is not implemented.');
    }

    public function getAuthKey()
    {
        throw new NotSupportedException(__METHOD__ . ' is not implemented.');
    }

    public static function findIdentity($id)
    {
        throw new NotSupportedException(__METHOD__ . ' is not implemented.');
    }

    public function getId()
    {
        throw new NotSupportedException(__METHOD__ . ' is not implemented.');
    }

    public static function findIdentityByAccessToken($token, $type = null)
    {
        throw new NotSupportedException(__METHOD__ . ' is not implemented.');
    }
}