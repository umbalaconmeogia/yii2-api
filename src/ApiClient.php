<?php
namespace umbalaconmeogia\yii2api;

use yii\httpclient\Client;
use yii\base\Component;

/**
 * Class to help requesting to an API.
 * @author thanh
 *
 */
class ApiClient extends Component
{
    const HEASDER_KEY_AUTHORIZATION = 'Authorization';

    /**
     * @var string
     */
    public $clientUser;

    /**
     * @var string
     */
    public $clientPassword;

    /**
     * @var string
     */
    public $baseUrl;

    public function request($apiName, $queryData, $requestMethod = 'POST')
    {
        $client = new Client([
            'transport' => 'yii\httpclient\CurlTransport',
            'baseUrl' => $this->baseUrl,
        ]);
        // Copy header from current request.
        $request = $client->createRequest();
        $request->setHeaders(\Yii::$app->request->headers)
            ->getHeaders()->remove(self::HEASDER_KEY_AUTHORIZATION); // Remove Authorization.
        // Set another request attributes.
        $request->addHeaders([self::HEASDER_KEY_AUTHORIZATION => 'Basic ' . base64_encode("{$this->clientUser}:{$this->clientPassword}")])
            ->setMethod($requestMethod)
            ->setUrl($apiName)
            ->setData($queryData);
        return $request->send();
    }

    public function get($apiName, $queryData)
    {
        return $this->request($apiName, $queryData, 'GET');
    }
}