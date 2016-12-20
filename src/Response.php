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

namespace Rinvex\Authy;

use Psr\Http\Message\ResponseInterface;

class Response
{
    /**
     * The raw Http response instance.
     *
     * @var \Psr\Http\Message\ResponseInterface
     */
    protected $httpResponse;

    /**
     * Create a new Authy response instance.
     *
     * @param \Psr\Http\Message\ResponseInterface $httpResponse
     */
    public function __construct(ResponseInterface $httpResponse)
    {
        $this->httpResponse = $httpResponse;
    }

    /**
     * Get Authy response status code.
     *
     * @return int
     */
    public function statusCode()
    {
        return $this->httpResponse->getStatusCode();
    }

    /**
     * Return Authy response body as array.
     *
     * @return array
     */
    public function body()
    {
        return json_decode($this->httpResponse->getBody(), true) ?: [];
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
        $body = $this->body();

        return isset($body[$var]) ? $body[$var] : null;
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
        return $this->statusCode() == 200 && $this->isSuccess($this->get('success'));
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
        return ! is_null($result) ? (is_string($result) && $result == 'true') || (is_bool($result) && $result) : false;
    }
}
