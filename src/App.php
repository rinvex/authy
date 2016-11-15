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

class App extends Client
{
    /**
     * Return application stats.
     *
     * @param string|null $ip
     *
     * @return \Rinvex\Authy\Response
     */
    public function stats($ip = null)
    {
        // Prepare required variables
        $url    = $this->api.'app/stats';
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
    public function details($ip = null)
    {
        // Prepare required variables
        $url    = $this->api.'app/details';
        $params = $this->params + ['query' => ['user_ip' => $ip]];

        // Return Authy application stats
        return new Response($this->http->get($url, $params));
    }
}
