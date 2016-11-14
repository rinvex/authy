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

namespace Rinvex\Authy\Test\Integration;

use Rinvex\Authy\App as AuthyApp;

class AppTest extends TestCase
{
    /** @var \Rinvex\Authy\App */
    protected $authyApp;

    /** @var \GuzzleHttp\Psr7\Response */
    protected $httpResponse;

    /** @var \Rinvex\Authy\Response */
    protected $authyResponse;

    public function setUp()
    {
        parent::setUp();

        $this->authyApp = new AuthyApp($this->http, static::API_KEY_SANDBOX, 'sandbox');
    }

    /** @test */
    public function it_returns_error_when_wrong_api_provided()
    {
        $authyApp = new AuthyApp($this->http, 'WrongApiKey', 'sandbox');
        $result = $authyApp->stats();

        $this->assertTrue($result->failed());
        $this->assertNotEmpty($result->errors());
        $this->assertContains('Invalid API key', $result->message());
    }

    /** @test */
    public function it_returns_stats()
    {
        $stats = $this->authyApp->stats();

        $this->assertTrue($stats->succeed());
        $this->assertArrayHasKey('stats', $stats->body());
        $this->assertContains('Monthly statistics', $stats->message());
    }

    /** @test */
    public function it_returns_stats_and_records_user_ip()
    {
        $stats = $this->authyApp->stats('192.168.10.10');

        $this->assertTrue($stats->succeed());
        $this->assertArrayHasKey('stats', $stats->body());
        $this->assertContains('Monthly statistics', $stats->message());
    }

    /** @test */
    public function it_returns_details()
    {
        $details = $this->authyApp->details();

        $this->assertTrue($details->succeed());
        $this->assertArrayHasKey('app', $details->body());
        $this->assertContains('Application information', $details->message());
    }

    /** @test */
    public function it_returns_details_and_records_user_ip()
    {
        $details = $this->authyApp->details('192.168.10.10');

        $this->assertTrue($details->succeed());
        $this->assertArrayHasKey('app', $details->body());
        $this->assertContains('Application information', $details->message());
    }
}
