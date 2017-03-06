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

namespace Rinvex\Authy\Test\Unit;

use Rinvex\Authy\Client as AuthyClient;
use Rinvex\Authy\Exceptions\InvalidConfiguration;

class ClientTest extends TestCase
{
    /** @var \Rinvex\Authy\Client */
    protected $authyClient;

    public function setUp()
    {
        parent::setUp();

        $this->authyClient = new AuthyClient($this->http, static::API_KEY_PRODUCTION);
    }

    /** @test */
    public function it_throws_an_exception_when_it_is_not_configured()
    {
        $this->expectException(InvalidConfiguration::class);

        new AuthyClient($this->http, null, null);
    }

    /** @test */
    public function it_can_set_api_response_format_to_xml()
    {
        $authy = new AuthyClient($this->http, static::API_KEY_PRODUCTION, 'xml');

        $this->assertAttributeContains('xml', 'api', $authy);
    }

    /** @test */
    public function it_defaults_api_endpoint_mode_to_production()
    {
        $this->assertAttributeContains('https://api.authy.com', 'api', $this->authyClient);
    }

    /** @test */
    public function it_defaults_api_response_format_to_json()
    {
        $this->assertAttributeContains('json', 'api', $this->authyClient);
    }

    /** @test */
    public function it_defaults_http_client_exceptions_to_false_and_sets_authy_key_header_on_params()
    {
        $this->assertAttributeEquals(['http_errors' => false, 'headers' => ['X-Authy-API-Key' => static::API_KEY_PRODUCTION]], 'params', $this->authyClient);
    }
}
