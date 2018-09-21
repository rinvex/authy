<?php

declare(strict_types=1);

namespace Rinvex\Authy\Test\Unit;

use Rinvex\Authy\App as AuthyApp;
use Rinvex\Authy\Response as AuthyResponse;
use GuzzleHttp\Psr7\Response as HttpResponse;

class AppTest extends TestCase
{
    /** @var \Rinvex\Authy\App */
    protected $authyApp;

    /** @var \GuzzleHttp\Psr7\Response */
    protected $httpResponse;

    /** @var \Rinvex\Authy\Response */
    protected $authyResponse;

    protected function setUp()
    {
        parent::setUp();

        $this->authyApp = new AuthyApp($this->http, static::API_KEY_PRODUCTION);
        $this->httpResponse = new HttpResponse(200, [], json_encode(['success' => true]));
        $this->authyResponse = new AuthyResponse($this->httpResponse);
    }

    /** @test */
    public function it_returns_stats()
    {
        $url = $this->api.'app/stats';
        $params = $this->params + ['query' => ['user_ip' => null]];

        $this->http->shouldReceive('get')->once()->with($url, $params)->andReturn($this->httpResponse);
        $this->assertEquals($this->authyResponse, $this->authyApp->stats());
    }

    /** @test */
    public function it_returns_stats_and_records_user_ip()
    {
        $url = $this->api.'app/stats';
        $params = $this->params + ['query' => ['user_ip' => '192.168.10.10']];

        $this->http->shouldReceive('get')->once()->with($url, $params)->andReturn($this->httpResponse);
        $this->assertEquals($this->authyResponse, $this->authyApp->stats('192.168.10.10'));
    }

    /** @test */
    public function it_returns_details()
    {
        $url = $this->api.'app/details';
        $params = $this->params + ['query' => ['user_ip' => null]];

        $this->http->shouldReceive('get')->once()->with($url, $params)->andReturn($this->httpResponse);
        $this->assertEquals($this->authyResponse, $this->authyApp->details());
    }

    /** @test */
    public function it_returns_details_and_records_user_ip()
    {
        $url = $this->api.'app/details';
        $params = $this->params + ['query' => ['user_ip' => '192.168.10.10']];

        $this->http->shouldReceive('get')->once()->with($url, $params)->andReturn($this->httpResponse);
        $this->assertEquals($this->authyResponse, $this->authyApp->details('192.168.10.10'));
    }
}
