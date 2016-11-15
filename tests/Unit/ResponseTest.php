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

use PHPUnit_Framework_TestCase;
use Rinvex\Authy\Response as AuthyResponse;
use GuzzleHttp\Psr7\Response as HttpResponse;

class ResponseTest extends PHPUnit_Framework_TestCase
{
    /** @test */
    public function it_returns_http_status_code()
    {
        $statusCodes      = [200, 400, 401, 503];
        $randomStatusCode = $statusCodes[array_rand($statusCodes)];
        $httpResponse     = new HttpResponse($randomStatusCode);
        $authyResponse    = new AuthyResponse($httpResponse);

        $this->assertInternalType('int', $randomStatusCode);
        $this->assertEquals($randomStatusCode, $authyResponse->statusCode());
    }

    /** @test */
    public function it_returns_body_content_as_array_when_valid()
    {
        $httpResponse  = new HttpResponse(200, [], json_encode(['key' => 'value']));
        $authyResponse = new AuthyResponse($httpResponse);
        $body          = $authyResponse->body();

        $this->assertInternalType('array', $body);
        $this->assertArrayHasKey('key', $body);
        $this->assertEquals($body['key'], 'value');
    }

    /** @test */
    public function it_returns_null_when_body_content_invalid()
    {
        $httpResponse  = new HttpResponse(200);
        $authyResponse = new AuthyResponse($httpResponse);
        $body          = $authyResponse->body();

        $this->assertInternalType('array', $body);
        $this->assertEmpty($body);
    }

    /** @test */
    public function it_returns_value_when_body_variable_exists()
    {
        $httpResponse  = new HttpResponse(200, [], json_encode(['key' => 'value']));
        $authyResponse = new AuthyResponse($httpResponse);

        $this->assertEquals('value', $authyResponse->get('key'));
    }

    /** @test */
    public function it_returns_null_when_body_variable_not_exist()
    {
        $httpResponse  = new HttpResponse(200);
        $authyResponse = new AuthyResponse($httpResponse);

        $this->assertNull($authyResponse->get('key'));
    }

    /** @test */
    public function it_returns_body_message_when_exists()
    {
        $httpResponse  = new HttpResponse(200, [], json_encode(['message' => 'Something']));
        $authyResponse = new AuthyResponse($httpResponse);

        $this->assertContains('Something', $authyResponse->message());
    }

    /** @test */
    public function it_returns_null_when_body_message_not_exist()
    {
        $httpResponse  = new HttpResponse(200);
        $authyResponse = new AuthyResponse($httpResponse);

        $this->assertNull($authyResponse->message());
    }

    /** @test */
    public function it_succeed_on_valid_status_code_and_valid_body()
    {
        $httpResponse  = new HttpResponse(200, [], json_encode(['success' => true]));
        $authyResponse = new AuthyResponse($httpResponse);

        $this->assertTrue($authyResponse->succeed());
        $this->assertFalse($authyResponse->failed());
    }

    /** @test */
    public function it_fails_on_invalid_status_code()
    {
        $httpResponse  = new HttpResponse(401, [], json_encode(['success' => true]));
        $authyResponse = new AuthyResponse($httpResponse);

        $this->assertTrue($authyResponse->failed());
        $this->assertFalse($authyResponse->succeed());
    }

    /** @test */
    public function it_fail_on_invalid_body()
    {
        $httpResponse1  = new HttpResponse(200);
        $authyResponse1 = new AuthyResponse($httpResponse1);

        $httpResponse2  = new HttpResponse(200, [], json_encode(['success' => false]));
        $authyResponse2 = new AuthyResponse($httpResponse2);

        $this->assertTrue($authyResponse1->failed());
        $this->assertFalse($authyResponse1->succeed());
        $this->assertTrue($authyResponse2->failed());
        $this->assertFalse($authyResponse2->succeed());
    }

    /** @test */
    public function it_returns_empty_errors_array_when_request_success_and_no_errors()
    {
        $httpResponse  = new HttpResponse(200, [], json_encode(['success' => true]));
        $authyResponse = new AuthyResponse($httpResponse);

        $this->assertEmpty($authyResponse->errors());
        $this->assertFalse($authyResponse->failed());
        $this->assertTrue($authyResponse->succeed());
    }

    /** @test */
    public function it_returns_empty_errors_array_when_request_success_even_when_errors_exists()
    {
        $httpResponse  = new HttpResponse(200, [], json_encode(['success' => true, 'errors' => ['foo' => 'bar']]));
        $authyResponse = new AuthyResponse($httpResponse);

        $this->assertEmpty($authyResponse->errors());
        $this->assertFalse($authyResponse->failed());
        $this->assertTrue($authyResponse->succeed());
    }

    /** @test */
    public function it_returns_errors_when_exists()
    {
        $httpResponse  = new HttpResponse(503, [], json_encode(['errors' => ['foo' => 'bar']]));
        $authyResponse = new AuthyResponse($httpResponse);
        $errors        = $authyResponse->errors();

        $this->assertTrue($authyResponse->failed());
        $this->assertInternalType('array', $errors);
        $this->assertArrayHasKey('foo', $errors);
    }
}
