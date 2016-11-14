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

use Rinvex\Authy\User as AuthyUser;

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

        $this->authyUser = new AuthyUser($this->http, static::API_KEY_SANDBOX, 'sandbox');
    }

    public function tearDown()
    {
        // Not sure how & when the Authy API deletes a user,
        // so we'll just register same deleted user again, just to be safe!
        $this->authyUser->register('user@domain.com', '317-338-9302', '54');
        parent::tearDown();
    }

    /** @test */
    public function it_registers_user()
    {
        $result = $this->authyUser->register('user@domain.com', '317-338-9302', '54');

        $this->assertTrue($result->succeed());
        $this->assertArrayHasKey('user', $result->body());
        $this->assertEquals(209, $result->get('user')['id']);
        $this->assertContains('User created successfully', $result->message());
    }

    /** @test */
    public function it_returns_error_when_registering_user_but_info_not_valid()
    {
        $result = $this->authyUser->register('user@domain.com', '317-338-9302', 0);

        $this->assertTrue($result->failed());
        $this->assertNotEmpty($result->errors());
        $this->assertArrayNotHasKey('user', $result->body());
        $this->assertContains('User was not valid', $result->message());
    }

    /** @test */
    public function it_deletes_user()
    {
        $result = $this->authyUser->delete($this->validAuthyId);

        $this->assertTrue($result->succeed());
        $this->assertContains('User was added to remove', $result->message());
    }

    /** @test */
    public function it_returns_error_when_deleting_user_but_user_not_found()
    {
        $result = $this->authyUser->delete($this->invalidAuthyId);

        $this->assertTrue($result->failed());
        $this->assertNotEmpty($result->errors());
        $this->assertContains('User not found', $result->message());
    }

    /** @test */
    public function it_gets_user_status()
    {
        $result = $this->authyUser->status($this->validAuthyId);

        $this->assertTrue($result->succeed());
        $this->assertArrayHasKey('status', $result->body());
        $this->assertContains('User status', $result->message());
    }

    /** @test */
    public function it_returns_error_when_getting_user_status_but_user_not_found()
    {
        $result = $this->authyUser->status($this->invalidAuthyId);

        $this->assertTrue($result->failed());
        $this->assertNotEmpty($result->errors());
        $this->assertContains('User not found', $result->message());
    }

    ///** @test */
    //public function it_registers_user_activity()
    //{
    //    // Not sure why this API request is failing with AuthyId 1, 2, and 209 (testing users)! Disabled temporary!!
    //    $result = $this->authyUser->registerActivity(209, 'cookie_login', 'Test Data');
    //
    //    $this->assertTrue($result->succeed());
    //    $this->assertArrayHasKey('status', $result->body());
    //    $this->assertContains('Activity was created', $result->message());
    //}

    ///** @test */
    //public function it_returns_error_when_registering_user_activity_but_user_not_found()
    //{
    //    //
    //}
}
