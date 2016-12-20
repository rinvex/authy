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

use Rinvex\Authy\Token as AuthyToken;
use Rinvex\Authy\Response as AuthyResponse;
use GuzzleHttp\Psr7\Response as HttpResponse;

class TokenTest extends TestCase
{
    /** @var \Rinvex\Authy\Token */
    protected $authyToken;

    /** @var \GuzzleHttp\Psr7\Response */
    protected $httpResponse;

    /** @var \Rinvex\Authy\Response */
    protected $authyResponse;

    public function setUp()
    {
        parent::setUp();

        $this->authyToken = new AuthyToken($this->http, static::API_KEY_PRODUCTION);
        $this->httpResponse = new HttpResponse(200, [], json_encode(['success' => true]));
        $this->authyResponse = new AuthyResponse($this->httpResponse);
    }

    /** @test */
    public function it_defaults_sending_token_as_sms()
    {
        $url = $this->api."sms/{$this->validAuthyId}";
        $params = $this->params + ['query' => ['force' => false, 'action' => null, 'actionMessage' => null]];

        $this->http->shouldReceive('get')->once()->with($url, $params)->andReturn($this->httpResponse);
        $this->assertEquals($this->authyResponse, $this->authyToken->send($this->validAuthyId));
    }

    /** @test */
    public function it_sends_token_as_phone_call()
    {
        $url = $this->api."call/{$this->validAuthyId}";
        $params = $this->params + ['query' => ['force' => false, 'action' => null, 'actionMessage' => null]];

        $this->http->shouldReceive('get')->once()->with($url, $params)->andReturn($this->httpResponse);
        $this->assertEquals($this->authyResponse, $this->authyToken->send($this->validAuthyId, 'call'));
    }

    /** @test */
    public function it_enforces_sending_token_over_cellphone_network()
    {
        $url = $this->api."sms/{$this->validAuthyId}";
        $params = $this->params + ['query' => ['force' => true, 'action' => null, 'actionMessage' => null]];

        $this->http->shouldReceive('get')->once()->with($url, $params)->andReturn($this->httpResponse);
        $this->assertEquals($this->authyResponse, $this->authyToken->send($this->validAuthyId, 'sms', true));
    }

    /** @test */
    public function it_sets_action_and_action_message()
    {
        $url = $this->api."sms/{$this->validAuthyId}";
        $params = $this->params + ['query' => ['force' => false, 'action' => 'login', 'actionMessage' => 'Login Code']];

        $this->http->shouldReceive('get')->once()->with($url, $params)->andReturn($this->httpResponse);
        $this->assertEquals($this->authyResponse, $this->authyToken->send($this->validAuthyId, 'sms', false, 'login', 'Login Code'));
    }

    /** @test */
    public function it_verifies_token()
    {
        $url = $this->api."verify/{$this->validToken}/{$this->validAuthyId}";
        $params = $this->params + ['query' => ['force' => false, 'action' => null]];

        $this->http->shouldReceive('get')->once()->with($url, $params)->andReturn($this->httpResponse);
        $this->assertEquals($this->authyResponse, $this->authyToken->verify($this->validToken, $this->validAuthyId));
    }

    /** @test */
    public function it_enforces_token_verification_regardless_registration_completeness()
    {
        $url = $this->api."verify/{$this->validToken}/{$this->validAuthyId}";
        $params = $this->params + ['query' => ['force' => true, 'action' => null]];

        $this->http->shouldReceive('get')->once()->with($url, $params)->andReturn($this->httpResponse);
        $this->assertEquals($this->authyResponse, $this->authyToken->verify($this->validToken, $this->validAuthyId, true));
    }

    /** @test */
    public function it_verifies_token_action()
    {
        $url = $this->api."verify/{$this->validToken}/{$this->validAuthyId}";
        $params = $this->params + ['query' => ['force' => false, 'action' => 'login']];

        $this->http->shouldReceive('get')->once()->with($url, $params)->andReturn($this->httpResponse);
        $this->assertEquals($this->authyResponse, $this->authyToken->verify($this->validToken, $this->validAuthyId, false, 'login'));
    }

    /** @test */
    public function it_returns_errors_array_when_request_fails_and_errors_exists()
    {
        $url = $this->api."sms/{$this->validAuthyId}";
        $params = $this->params + ['query' => ['force' => false, 'action' => null, 'actionMessage' => null]];
        $httpResponse = new HttpResponse(200, [], json_encode(['success' => false, 'errors' => ['foo' => 'bar']]));
        $authyResponse = new AuthyResponse($httpResponse);

        $this->http->shouldReceive('get')->once()->with($url, $params)->andReturn($httpResponse);
        $this->assertEquals($authyResponse, $this->authyToken->send($this->validAuthyId));
        $this->assertTrue($authyResponse->failed());
        $this->assertNotEmpty($authyResponse->errors());
    }

    /** @test */
    public function it_returns_empty_errors_array_when_request_success_even_when_errors_exists()
    {
        $url = $this->api."sms/{$this->validAuthyId}";
        $params = $this->params + ['query' => ['force' => false, 'action' => null, 'actionMessage' => null]];
        $httpResponse = new HttpResponse(200, [], json_encode(['success' => true, 'errors' => ['foo' => 'bar']]));
        $authyResponse = new AuthyResponse($httpResponse);

        $this->http->shouldReceive('get')->once()->with($url, $params)->andReturn($httpResponse);
        $this->assertEquals($authyResponse, $this->authyToken->send($this->validAuthyId));
        $this->assertTrue($authyResponse->succeed());
        $this->assertEmpty($authyResponse->errors());
    }
}
