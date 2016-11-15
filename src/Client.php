<?php

/*
 * NOTICE OF LICENSE
 *
 * Part of the Rinvex Authy Package.
 *
 * This source file is subject to The MIT License (MIT)
 * that is bundled with this package in the LICENSE file.
 *
 * Package: Rinvex Authy Package
 * License: The MIT License (MIT)
 * Link:    https://rinvex.com
 */

namespace Rinvex\Authy;

use GuzzleHttp\ClientInterface;
use Rinvex\Authy\Exceptions\InvalidConfiguration;

class Client
{
    /**
     * The Authy production API endpoint.
     *
     * @var string
     */
    const API_ENDPOINT_PRODUCTION = 'https://api.authy.com';

    /**
     * The Authy sandbox API endpoint.
     *
     * @var string
     */
    const API_ENDPOINT_SANDBOX = 'http://sandbox-api.authy.com';

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
     * @param string                      $mode
     *
     * @throws \Rinvex\Authy\Exceptions\InvalidConfiguration
     */
    public function __construct(ClientInterface $client, $key, $mode = 'production', $format = 'json')
    {
        // Prepare required data
        $this->http   = $client;
        $format       = $format == 'xml' ? 'xml' : 'json';
        $this->params = ['http_errors' => false, 'headers' => ['X-Authy-API-Key' => $key]];
        $base         = $mode == 'sandbox' ? static::API_ENDPOINT_SANDBOX : static::API_ENDPOINT_PRODUCTION;
        $this->api    = "{$base}/protected/{$format}/";

        // Check configuration
        if (! $mode || ! $key) {
            throw InvalidConfiguration::missingCredentials();
        }
    }
}
