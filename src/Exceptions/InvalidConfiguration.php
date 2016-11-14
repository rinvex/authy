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

namespace Rinvex\Authy\Exceptions;

use Exception;

class InvalidConfiguration extends Exception
{
    public static function missingCredentials()
    {
        return new static('You need to add `authy` credentials in `config/services.php`.');
    }
}
