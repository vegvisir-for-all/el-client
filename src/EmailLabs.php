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

namespace EmailLabs;

use EmailLabs\Client\ElClient;
use EmailLabs\Message\ElMessage;
use EmailLabs\Message\ElMessageWithTemplate;

class EmailLabs
{
    /**
     * @var ElClient
     */
    protected $client;

    /**
     * @var string
     */
    protected $smtpAccount;

    /**
     * Class constructor.
     *
     * @param string $appKey
     * @param string $secretKey
     * @param string $smtpAccount
     */
    public function __construct($appKey, $secretKey, $smtpAccount)
    {
        $this->client = new ElClient($appKey, $secretKey, $smtpAccount);
        $this->smtpAccount = $smtpAccount;
    }

    /**
     * ElMessage factory.
     *
     * @param null|array $fields
     *
     * @return ElMessage
     */
    public function message($fields = [])
    {
        $fields['smtp_account'] = $this->smtpAccount;

        return new ElMessage($fields);
    }

    /**
     * ElMessageWithTemplate factory.
     *
     * @param null|array  $fields
     * @param null|string $templateId
     *
     * @return ElMessageWithTemplate
     */
    public function messageWithTemplate($fields = [], $templateId = null)
    {
        $fields['smtp_account'] = $this->smtpAccount;

        return new ElMessageWithTemplate($fields, $templateId);
    }

    /**
     * Send message.
     *
     * @param array|ElMessage|ElMessageWithTemplate $messages
     *
     * @return object
     */
    public function send($messages)
    {
        if (!\is_array($messages)) {
            $messages = [$messages];
        }

        foreach ($messages as $key => $message) {
            if (is_a($message, ElMessage::class, true)) {
                $result[$key] = $this->client->send($message->elData());
            }
            if (is_a($message, ElMessageWithTemplate::class, true)) {
                $result[$key] = $this->client->sendWithTemplate($message->elData(true));
            }
        }

        return $result;
    }
}
