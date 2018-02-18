<?php

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
    public function statusCode(): int
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
    public function message(): string
    {
        return $this->get('message');
    }

    /**
     * Determine if the Authy response succeed.
     *
     * @return bool
     */
    public function succeed(): bool
    {
        return $this->statusCode() === 200 && $this->isSuccess($this->get('success'));
    }

    /**
     * Determine if the Authy response failed.
     *
     * @return bool
     */
    public function failed(): bool
    {
        return ! $this->succeed();
    }

    /**
     * Get Authy response errors.
     *
     * @return array
     */
    public function errors(): array
    {
        $errors = $this->get('errors') ?: [];

        return $this->failed() && ! empty($errors) ? $errors : [];
    }

    /**
     * Determine if the given result is success.
     *
     * @return bool
     */
    protected function isSuccess($result): bool
    {
        return ! is_null($result) ? (is_string($result) && $result === 'true') || (is_bool($result) && $result) : false;
    }
}
