<?php

declare(strict_types=1);

namespace Rinvex\Authy\Tests;

use Mockery;
use PHPUnit\Framework\TestCase as BaseTestCase;

class TestCase extends BaseTestCase
{
    /** @var string */
    const API_KEY_PRODUCTION = 'AuthySecretKey';

    /** @var \GuzzleHttp\ClientInterface */
    protected $http;

    /** @var array */
    protected $params;

    /** @var string */
    protected $api;

    /** @var int */
    protected $validAuthyId = 2;

    /** @var int */
    protected $invalidAuthyId = 0;

    /** @var int */
    protected $validToken = '0000000';

    /** @var int */
    protected $invalidToken = '1234567';

    protected function tearDown()
    {
        Mockery::close();
        parent::tearDown();
    }
}
