<?php

declare(strict_types=1);

namespace Rinvex\Authy;

class App extends Client
{
    /**
     * Return application stats.
     *
     * @param string|null $ip
     *
     * @return \Rinvex\Authy\Response
     */
    public function stats($ip = null): Response
    {
        // Prepare required variables
        $url = $this->api.'app/stats';
        $params = $this->params + ['query' => ['user_ip' => $ip]];

        // Return Authy application stats
        return new Response($this->http->get($url, $params));
    }

    /**
     * Get application details.
     *
     * @param string|null $ip
     *
     * @return \Rinvex\Authy\Response
     */
    public function details($ip = null): Response
    {
        // Prepare required variables
        $url = $this->api.'app/details';
        $params = $this->params + ['query' => ['user_ip' => $ip]];

        // Return Authy application stats
        return new Response($this->http->get($url, $params));
    }
}
