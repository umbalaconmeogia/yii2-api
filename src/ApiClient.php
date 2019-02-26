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
    const HEADERS_KEY_AUTHORIZATION = 'Authorization';
    const HEADERS_KEY_ACCEPT = 'Accept';

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

    /**
     * Accept return result.
     * @var string
     */
    public $headerAccept = 'application/json';

    public function request($apiName, $queryData = null, $requestMethod = 'POST')
    {
        $client = new Client([
            'transport' => 'yii\httpclient\CurlTransport',
            'baseUrl' => $this->baseUrl,
        ]);
        // Copy header from current request.
        $request = $client->createRequest();
        $request->setHeaders(\Yii::$app->request->headers);
        $headers = $request->getHeaders();
        $headers->remove(self::HEADERS_KEY_AUTHORIZATION); // Remove Authorization.
        $headers->remove(self::HEADERS_KEY_ACCEPT); // Remove Accept.
        // Set another request attributes.
        $request->addHeaders([
                self::HEADERS_KEY_AUTHORIZATION => 'Basic ' . base64_encode("{$this->clientUser}:{$this->clientPassword}"),
                self::HEADERS_KEY_ACCEPT => $this->headerAccept,
            ])
            ->setMethod($requestMethod)
            ->setUrl($apiName)
            ->setData($queryData);
        return $request->send();
    }

    public function get($apiName, $queryData = null)
    {
        return $this->request($apiName, $queryData, 'GET');
    }
}