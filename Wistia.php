<?php

namespace Wistia;

use GuzzleHttp\Client as GuzzleClient;

class Wistia
{
    private $client;
    private $format = 'json';
    private $baseUrl = 'https://api.wistia.com/v1/';
    private $httpClient;
    
    public function __construct(Client $client)
    {
        $this->client = $client;
        $this->httpClient = new GuzzleClient();
    }

    /**
     * @return Client
     */
    public function getClient()
    {
        return $this->client;
    }
    
    public function call($type, $params = [], $request = 'get')
    {
        $url = $this->baseUrl . $type . '.' . $this->format;

        $options = [];
        $options['auth'] = [
            'api',
            $this->getClient()->getApiKey()
        ];

        if ($request === 'post' || $request === 'put') {
            $options['form_params'] = $params;
        } else {
            $options['query'] = $params;
        }

        $data = $this->httpClient->request($request, $url, $options);

        return $data;
    }

}