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

namespace Rinvex\Authy\Test\Unit;

use Mockery;
use GuzzleHttp\Client as HttpClient;
use Rinvex\Authy\Test\TestCase as BaseTestCase;

class TestCase extends BaseTestCase
{
    public function setUp()
    {
        parent::setUp();

        $this->http = Mockery::mock(HttpClient::class);
        $this->api = static::API_ENDPOINT_PRODUCTION."/protected/json/";
        $this->params = ['http_errors' => false, 'headers' => ['X-Authy-API-Key' => static::API_KEY_PRODUCTION]];
    }
}
