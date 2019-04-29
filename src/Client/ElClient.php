<?php

/*
 * This file is a part of vegvisir/el-client - a PHP client
 * for EmailLabs.pl API.
 *
 * @copy 2019 Sigrun Sp. z o.o.
 * @license MIT License
 * @author Vegvisir Sp. z o.o. <vegvisir@vegvisir.pl>
 * @author Sigrun Sp. z o.o. <sigrun@sigrun.eu>
 * @author Marek Ognicki <marek@ognicki.pl>
 */

namespace EmailLabs\Client;

use GuzzleHttp\Client;

class ElClient
{
    /**
     * App key.
     *
     * @var string
     */
    protected $appKey;

    /**
     * Secret key.
     *
     * @var string
     */
    protected $secretKey;

    /**
     * SMTP client name.
     *
     * @var string
     */
    protected $smtpAccount;

    /**
     * Guzzle client container.
     *
     * @var GuzzleHttp\Client
     */
    protected $client;

    /**
     * Class constructor.
     *
     * @param string $appKey
     * @param string $secretKey
     * @param string $smtpAccount
     */
    public function __construct($appKey, $secretKey, $smtpAccount)
    {
        $this->appKey = $appKey;
        $this->secretKey = $secretKey;
        $this->smtpAccount = $smtpAccount;

        $this->client = new Client([
            'base_uri' => 'https://api.emaillabs.net.pl/api/',
        ]);
    }

    /**
     * Send mail.
     *
     * @param BaseMessage $message
     *
     * @return object
     */
    public function send($message)
    {
        return $this->makeRequest('new_sendmail', $message);
    }

    /**
     * Send mail with templates.
     *
     * @param BaseMessage $message
     *
     * @return object
     */
    public function sendWithTemplate($message)
    {
        return $this->makeRequest('sendmail_templates', $message);
    }

    /**
     * Make request to EmailLabs.
     *
     * @param string $endpoint
     * @param array  $formParams
     * @param string $method
     *
     * @return object
     */
    protected function makeRequest($endpoint, $formParams, $method = 'POST')
    {
        $result = $this->client->request($method, $endpoint, [
            'form_params' => $formParams,
            'auth' => [$this->appKey, $this->secretKey],
        ]);

        return json_decode($result->getBody());
    }
}
