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

class User extends Client
{
    /**
     * Register a new Authy user.
     *
     * @param string $email
     * @param string $cellphone
     * @param string $countryCode
     * @param bool   $sendInstallLink
     *
     * @return \Rinvex\Authy\Response
     */
    public function register($email, $cellphone, $countryCode, $sendInstallLink = true)
    {
        // Prepare required variables
        $url    = $this->api.'users/new';
        $params = $this->params + [
            'form_params' => [
                'send_install_link_via_sms' => (bool) $sendInstallLink,
                'user'                      => [
                    'email'        => $email,
                    'cellphone'    => preg_replace('/[^0-9]/', '', $cellphone),
                    'country_code' => $countryCode,
                ],
            ],
        ];

        // Register Authy user, and return response
        return new Response($this->http->post($url, $params));
    }

    /**
     * Register the given user activity.
     *
     * @param int         $authyId
     * @param string      $type
     * @param string      $data
     * @param string|null $ip
     *
     * @return \Rinvex\Authy\Response
     */
    public function registerActivity($authyId, $type, $data, $ip = null)
    {
        // Prepare required variables
        $url    = $this->api."users/{$authyId}/register_activity";
        $params = $this->params + ['form_params' => ['type' => $type, 'data' => $data, 'user_ip' => $ip]];

        // Register Authy user activity, and return response
        return new Response($this->http->post($url, $params));
    }

    /**
     * Get status of the given user.
     *
     * @param int         $authyId
     * @param string|null $ip
     *
     * @return \Rinvex\Authy\Response
     */
    public function status($authyId, $ip = null)
    {
        // Prepare required variables
        $url    = $this->api."users/{$authyId}/status";
        $params = $this->params + ['query' => ['user_ip' => $ip]];

        // Return Authy user status
        return new Response($this->http->get($url, $params));
    }

    /**
     * Delete the given Authy user.
     *
     * @param int         $authyId
     * @param string|null $ip
     *
     * @return \Rinvex\Authy\Response
     */
    public function delete($authyId, $ip = null)
    {
        // Prepare required variables
        $url    = $this->api."users/{$authyId}/delete";
        $params = $this->params + ['form_params' => ['ip' => $ip]];

        // Delete Authy user, and return response
        return new Response($this->http->post($url, $params));
    }
}
