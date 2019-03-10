<?php
namespace umbalaconmeogia\yii2api;

use yii\httpclient\Client;
use yii\base\Component;

/**
 * Class to help requesting to an API.
 *
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

    /**
     * Usage example:
     * <pre>
     *  $apiClient = \Yii::createObject(ApiClient::class);
     *  $request = ['sub-systems/request', 'sub_system' => $this->sub_system_client_user, 'request' => 'sub-system-user/sync-data'];
     *  $param = [
     *      'SubSystemUser' => [
     *          [
     *              'id' => $user->id,
     *              'username' => $user->username,
     *              'auth_key' => $user->auth_key,
     *              'data_status' => $this->access ? User::DATA_STATUS_ACTIVE : User::DATA_STATUS_DELETE,
     *          ],
     *      ],
     *  ];
     *  $clientResponse = $apiClient->request($request, $param);
     * </pre>
     *
     * TODO: Consider to add following setting into request headers.
     * Content-Type: application/x-www-form-urlencoded; charset=UTF-8
     * Accept-Encoding: gzip, deflate
     *
     * @param string|array $apiName Request part from URL root.
     * @param string|array $queryData Body of POST method. May be a string or an array (which will be converted automatically to x-www-form-urlencoded).
     * @param string $requestMethod 'GET' or 'POST'
     * @return \yii\httpclient\Response
     */
    public function request($apiName, $queryData = null, $requestMethod = 'POST')
    {
        $client = new Client([
            'transport' => 'yii\httpclient\CurlTransport',
            'baseUrl' => $this->baseUrl,
        ]);
        // Copy header from current request.
        $request = $client->createRequest();
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

    public function requestGet($apiName, $queryData = null)
    {
        return $this->request($apiName, $queryData, 'GET');
    }
}