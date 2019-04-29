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

namespace EmailLabs\Message;

class BaseMessage
{
    /**
     * @var array
     */
    protected $optionalFields = [
        'return_path',
        'new_structure',
        'from_name',
        'cc',
        'cc_name',
        'multi_cc',
        'bcc',
        'bcc_name',
        'multi_bcc',
        'reply_to',
        'tags',
        'headers',
        'files',
    ];

    /**
     * Class constructor.
     *
     * @param null|array $fields
     * @param null|bool  $template
     */
    public function __construct($fields = [], $template = false)
    {
        $this->create($fields);
    }

    /**
     * Return array formatted in EmailLabs manner.
     *
     * @param null|bool $template
     *
     * @return array
     */
    public function elData($template = false)
    {
        $elData = [];
        if (
            isset($this->to_name) ||
            isset($this->to_vars) ||
            isset($this->to_message_id)
        ) {
            $to = [];
            if (isset($this->to_name)) {
                $to['name'] = $this->to_name;
            }
            if (isset($this->to_vars)) {
                $to['vars'] = $this->to_vars;
            }
            if (isset($this->to_message_id)) {
                $to['message_id'] = $this->to_message_id;
            }
            $elData['to'][$this->to] = $to;
        } else {
            $elData['to'][$this->to] = $this->to;
        }
        $elData['smtp_account'] = $this->smtp_account;
        $elData['subject'] = $this->subject;
        $elData['from'] = $this->from;
        $elData['global_vars'] = isset($this->global_vars) ? $this->global_vars : [];

        if (!$template) {
            $elData['html'] = isset($this->html) ? $this->html : $this->text;
            $elData['text'] = $this->text;
        } else {
            if (isset($this->template_id)) {
                $elData['template_id'] = $this->template_id;
            }
        }

        foreach ($this->optionalFields as $key => $value) {
            if (isset($this->{$value})) {
                $elData[$key] = $this->{$value};
            }
        }

        return $elData;
    }

    /**
     * Fill model with properties.
     *
     * @param null|array $fields
     * @param null|bool  $template
     */
    protected function create($fields = [], $template = false)
    {
        foreach ($fields as $key => $value) {
            $this->{$key} = $value;
        }
    }
}
