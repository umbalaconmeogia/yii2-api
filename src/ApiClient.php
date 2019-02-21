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
    public $urlRoot;

    public function request($apiName, $queryData, $requestMethod = 'POST')
    {
        $client = new Client([
            'baseUrl' => $this->urlRoot,
            'transport' => 'yii\httpclient\CurlTransport',
        ]);
        $request = $client
            ->createRequest()
            ->addHeaders(['Authorization' => 'Basic ' . base64_encode("{$this->clientUser}:{$this->clientPassword}")])
            ->setMethod($requestMethod)
            ->setUrl($apiName)
            ->setData($queryData);
        $response = $request->send();
        return $response;
    }

    public function get($apiName, $queryData)
    {
        return $this->request($apiName, $queryData, 'GET');
    }
}