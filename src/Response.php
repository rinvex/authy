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

declare(strict_types=1);

namespace Rinvex\Authy;

use Psr\Http\Message\ResponseInterface;

class Response
{
    /**
     * The Aythy response body content as array.
     *
     * @var array
     */
    protected $body;

    /**
     * The Aythy response status code.
     *
     * @var int
     */
    protected $status;

    /**
     * Create a new Authy response instance.
     *
     * @param \Psr\Http\Message\ResponseInterface $httpResponse
     */
    public function __construct(ResponseInterface $httpResponse)
    {
        $this->status = $httpResponse->getStatusCode();
        $this->body = ($body = (string) $httpResponse->getBody()) ? json_decode($body, true) : null;
    }

    /**
     * Get Authy response status code.
     *
     * @return int
     */
    public function statusCode()
    {
        return $this->status;
    }
    /**
     * Get Authy response body item.
     *
     * @param string $var
     *
     * @return mixed
     */
    public function get($var)
    {
        return $this->body[$var] ?? null;
    }

    /**
     * Get Authy response body message.
     *
     * @return string
     */
    public function message()
    {
        return $this->get('message');
    }

    /**
     * Determine if the Authy response succeed.
     *
     * @return bool
     */
    public function succeed()
    {
        return $this->statusCode() === 200 && $this->isSuccess($this->get('success'));
    }

    /**
     * Determine if the Authy response failed.
     *
     * @return bool
     */
    public function failed()
    {
        return ! $this->succeed();
    }

    /**
     * Get Authy response errors.
     *
     * @return array
     */
    public function errors()
    {
        $errors = $this->get('errors') ?: [];

        return $this->failed() && ! empty($errors) ? $errors : [];
    }

    /**
     * Determine if the given result is success.
     *
     * @return bool
     */
    protected function isSuccess($result)
    {
        return ! is_null($result) ? (is_string($result) && $result === 'true') || (is_bool($result) && $result) : false;
    }
}
