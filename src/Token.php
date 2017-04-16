<?php

declare(strict_types=1);

namespace Rinvex\Authy;

class Token extends Client
{
    /**
     * Send verification token to the given Authy user.
     *
     * @param int         $authyId
     * @param string      $method
     * @param bool        $force
     * @param string|null $action
     * @param string|null $actionMessage
     *
     * @return \Rinvex\Authy\Response
     */
    public function send($authyId, $method = 'sms', $force = false, $action = null, $actionMessage = null): Response
    {
        // Prepare required variables
        $url = $this->api.$method."/{$authyId}";
        $params = $this->params + ['query' => ['force' => $force ? 'true' : 'false', 'action' => $action, 'actionMessage' => $actionMessage]];

        // Send Authy token, and return response
        return new Response($this->http->get($url, $params));
    }

    /**
     * Verify the given token for the given Authy user.
     *
     * @param int         $token
     * @param int         $authyId
     * @param bool        $force
     * @param string|null $action
     *
     * @return \Rinvex\Authy\Response
     */
    public function verify($token, $authyId, $force = false, $action = null): Response
    {
        // Prepare required variables
        $url = $this->api."verify/{$token}/{$authyId}";
        $params = $this->params + ['query' => ['force' => $force ? 'true' : 'false', 'action' => $action]];

        // Verify Authy token
        return new Response($this->http->get($url, $params));
    }
}
