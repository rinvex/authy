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

use Rinvex\Authy\Token as AuthyToken;

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

        $this->authyToken = new AuthyToken($this->http, static::API_KEY_SANDBOX, 'sandbox');
    }

    /** @test */
    public function it_defaults_sending_token_as_sms()
    {
        $result = $this->authyToken->send($this->validAuthyId);

        $this->assertTrue($result->succeed());
        $this->assertArrayHasKey('cellphone', $result->body());
        $this->assertContains('Token was sent', $result->message());
    }

    /** @test */
    public function it_sends_token_as_phone_call()
    {
        $result = $this->authyToken->send($this->validAuthyId, 'call');

        $this->assertTrue($result->succeed());
        $this->assertArrayHasKey('cellphone', $result->body());
        $this->assertContains('Call started', $result->message());
    }

    /** @test */
    public function it_returns_error_when_sending_token_but_user_not_found()
    {
        $result = $this->authyToken->send($this->invalidAuthyId);

        $this->assertTrue($result->failed());
        $this->assertNotEmpty($result->errors());
        $this->assertContains('User not found', $result->message());
    }

    /** @test */
    public function it_sets_action_and_action_message_when_sending_token()
    {
        $result = $this->authyToken->send($this->validAuthyId, 'sms', false, 'login', 'Login Code');

        $this->assertTrue($result->succeed());
        $this->assertArrayHasKey('cellphone', $result->body());
        $this->assertContains('Token was sent', $result->message());
    }

    /** @test */
    public function it_verifies_token()
    {
        $result = $this->authyToken->verify($this->validToken, $this->validAuthyId);

        $this->assertTrue($result->succeed());
        $this->assertContains('is valid', $result->get('token'));
        $this->assertContains('Token is valid', $result->message());
    }

    /** @test */
    public function it_returns_error_when_verifying_token_but_user_not_found()
    {
        $result = $this->authyToken->verify($this->validToken, $this->invalidAuthyId);

        $this->assertTrue($result->failed());
        $this->assertNotEmpty($result->errors());
        $this->assertContains("User doesn't exist", $result->message());
    }

    /** @test */
    public function it_returns_error_when_verifying_token_but_token_not_valid()
    {
        $result = $this->authyToken->verify($this->invalidToken, $this->validAuthyId);

        $this->assertTrue($result->failed());
        $this->assertNotEmpty($result->errors());
        $this->assertContains('is invalid', $result->get('token'));
        $this->assertContains('Token is invalid', $result->message());
    }

    /** @test */
    public function it_returns_error_when_verifying_token_but_both_user_and_token_are_not_invalid()
    {
        $result = $this->authyToken->verify($this->invalidToken, $this->invalidAuthyId);

        $this->assertTrue($result->failed());
        $this->assertNotEmpty($result->errors());
        $this->assertContains("User doesn't exist", $result->message());
    }
}
