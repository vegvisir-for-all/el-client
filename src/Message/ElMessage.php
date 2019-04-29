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

class ElMessage extends BaseMessage
{
    /**
     * Class constructor.
     *
     * @param null|array $fields
     * @param null|bool  $template
     */
    public function __construct($fields = [], $template = false)
    {
        parent::__construct($fields, false);
    }
}
