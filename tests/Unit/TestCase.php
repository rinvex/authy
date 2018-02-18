<?php

declare(strict_types=1);

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
        $this->api = 'https://api.authy.com/protected/json/';
        $this->params = ['http_errors' => false, 'headers' => ['X-Authy-API-Key' => static::API_KEY_PRODUCTION]];
    }
}
