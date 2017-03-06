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

declare(strict_types=1);

namespace Rinvex\Authy;

use GuzzleHttp\ClientInterface;
use Rinvex\Authy\Exceptions\InvalidConfiguration;

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
     * @throws \Rinvex\Authy\Exceptions\InvalidConfiguration
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
