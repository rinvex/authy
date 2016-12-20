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

namespace Rinvex\Authy\Test;

use Mockery;
use PHPUnit_Framework_TestCase;

class TestCase extends PHPUnit_Framework_TestCase
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

    public function tearDown()
    {
        Mockery::close();
        parent::tearDown();
    }
}
