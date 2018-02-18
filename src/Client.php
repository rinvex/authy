<?php

declare(strict_types=1);

namespace Rinvex\Authy;

use GuzzleHttp\ClientInterface;

class Client
{
    /**
     * The HTTP client instance.
     *
     * @var \GuzzleHttp\ClientInterface
     */
    protected $http;

    /**
     * The HTTP client parameters.
     *
     * @var array
     */
    protected $params;

    /**
     * The Authy service API endpoint.
     *
     * @var string
     */
    protected $api;

    /**
     * Create a new Authy client instance.
     *
     * @param \GuzzleHttp\ClientInterface $client
     * @param string                      $key
     * @param string                      $format
     *
     * @throws \Rinvex\Authy\InvalidConfiguration
     */
    public function __construct(ClientInterface $client, $key, $format = 'json')
    {
        // Prepare required data
        $this->http = $client;
        $format = $format === 'xml' ? 'xml' : 'json';
        $this->params = ['http_errors' => false, 'headers' => ['X-Authy-API-Key' => $key]];
        $this->api = "https://api.authy.com/protected/{$format}/";

        // Check configuration
        if (! $key) {
            throw InvalidConfiguration::missingCredentials();
        }
    }
}
