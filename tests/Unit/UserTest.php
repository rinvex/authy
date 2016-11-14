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

use Rinvex\Authy\User as AuthyUser;
use Rinvex\Authy\Response as AuthyResponse;
use GuzzleHttp\Psr7\Response as HttpResponse;

class UserTest extends TestCase
{
    /** @var \Rinvex\Authy\User */
    protected $authyUser;

    /** @var \GuzzleHttp\Psr7\Response */
    protected $httpResponse;

    /** @var \Rinvex\Authy\Response */
    protected $authyResponse;

    public function setUp()
    {
        parent::setUp();

        $this->authyUser     = new AuthyUser($this->http, static::API_KEY_PRODUCTION);
        $this->httpResponse  = new HttpResponse(200, [], json_encode(['success' => true]));
        $this->authyResponse = new AuthyResponse($this->httpResponse);
    }

    /** @test */
    public function it_registers_a_user()
    {
        $url    = $this->api.'users/new';
        $params = $this->params + [
            'form_params' => [
                'send_install_link_via_sms' => true,
                'user'                      => [
                    'email'        => 'test@example.com',
                    'cellphone'    => preg_replace('/[^0-9]/', '', '1234567890'),
                    'country_code' => '1',
                ],
            ],
        ];

        $this->http->shouldReceive('post')->once()->with($url, $params)->andReturn($this->httpResponse);
        $this->assertEquals($this->authyResponse, $this->authyUser->register('test@example.com', '1234567890', '1'));
    }

    /** @test */
    public function it_prevents_sending_install_link()
    {
        $url    = $this->api.'users/new';
        $params = $this->params + [
            'form_params' => [
                'send_install_link_via_sms' => false,
                'user'                      => [
                    'email'        => 'test@example.com',
                    'cellphone'    => preg_replace('/[^0-9]/', '', '1234567890'),
                    'country_code' => '1',
                ],
            ],
        ];

        $this->http->shouldReceive('post')->once()->with($url, $params)->andReturn($this->httpResponse);
        $this->assertEquals($this->authyResponse, $this->authyUser->register('test@example.com', '1234567890', '1', false));
    }

    /** @test */
    public function it_deletes_a_user()
    {
        $url    = $this->api."users/{$this->validAuthyId}/delete";
        $params = $this->params + ['form_params' => ['ip' => null]];

        $this->http->shouldReceive('post')->once()->with($url, $params)->andReturn($this->httpResponse);
        $this->assertEquals($this->authyResponse, $this->authyUser->delete($this->validAuthyId));
    }

    /** @test */
    public function it_deletes_a_user_and_records_user_ip()
    {
        $url    = $this->api."users/{$this->validAuthyId}/delete";
        $params = $this->params + ['form_params' => ['ip' => '192.168.10.10']];

        $this->http->shouldReceive('post')->once()->with($url, $params)->andReturn($this->httpResponse);
        $this->assertEquals($this->authyResponse, $this->authyUser->delete($this->validAuthyId, '192.168.10.10'));
    }

    /** @test */
    public function it_registers_user_activity()
    {
        $url    = $this->api."users/{$this->validAuthyId}/register_activity";
        $params = $this->params + ['form_params' => ['data' => 'Test Data', 'type' => 'cookie_login', 'user_ip' => null]];

        $this->http->shouldReceive('post')->once()->with($url, $params)->andReturn($this->httpResponse);
        $this->assertEquals($this->authyResponse, $this->authyUser->registerActivity($this->validAuthyId, 'cookie_login', 'Test Data'));
    }

    /** @test */
    public function it_registers_user_activity_and_records_user_ip()
    {
        $url    = $this->api."users/{$this->validAuthyId}/register_activity";
        $params = $this->params + ['form_params' => ['data' => 'Test Data', 'type' => 'cookie_login', 'user_ip' => '192.168.10.10']];

        $this->http->shouldReceive('post')->once()->with($url, $params)->andReturn($this->httpResponse);
        $this->assertEquals($this->authyResponse, $this->authyUser->registerActivity($this->validAuthyId, 'cookie_login', 'Test Data', '192.168.10.10'));
    }

    /** @test */
    public function it_returns_status()
    {
        $url    = $this->api."users/{$this->validAuthyId}/status";
        $params = $this->params + ['query' => ['user_ip' => null]];

        $this->http->shouldReceive('get')->once()->with($url, $params)->andReturn($this->httpResponse);
        $this->assertEquals($this->authyResponse, $this->authyUser->status($this->validAuthyId));
    }

    /** @test */
    public function it_returns_status_and_records_user_ip()
    {
        $url    = $this->api."users/{$this->validAuthyId}/status";
        $params = $this->params + ['query' => ['user_ip' => '192.168.10.10']];

        $this->http->shouldReceive('get')->once()->with($url, $params)->andReturn($this->httpResponse);
        $this->assertEquals($this->authyResponse, $this->authyUser->status($this->validAuthyId, '192.168.10.10'));
    }

    /** @test */
    public function it_returns_errors_array_when_request_fails_and_errors_exists()
    {
        $url           = $this->api."users/{$this->validAuthyId}/status";
        $params        = $this->params + ['query' => ['user_ip' => null]];
        $httpResponse  = new HttpResponse(200, [], json_encode(['success' => false, 'errors' => ['foo' => 'bar']]));
        $authyResponse = new AuthyResponse($httpResponse);

        $this->http->shouldReceive('get')->once()->with($url, $params)->andReturn($httpResponse);
        $this->assertEquals($authyResponse, $this->authyUser->status($this->validAuthyId));
    }

    /** @test */
    public function it_returns_empty_errors_array_when_request_success_even_when_errors_exists()
    {
        $url           = $this->api."users/{$this->validAuthyId}/status";
        $params        = $this->params + ['query' => ['user_ip' => null]];
        $httpResponse  = new HttpResponse(200, [], json_encode(['success' => true, 'errors' => ['foo' => 'bar']]));
        $authyResponse = new AuthyResponse($httpResponse);

        $this->http->shouldReceive('get')->once()->with($url, $params)->andReturn($httpResponse);
        $this->assertEquals($authyResponse, $this->authyUser->status($this->validAuthyId));
    }
}
