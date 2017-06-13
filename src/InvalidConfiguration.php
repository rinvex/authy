<?php

declare(strict_types=1);

namespace Rinvex\Authy;

use Exception;

class InvalidConfiguration extends Exception
{
    public static function missingCredentials()
    {
        return new static('Missing or invalid configuration!');
    }
}
