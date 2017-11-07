<?php

namespace NotificationChannels\Clicksend\Exceptions;

use Exception;

class InvalidConfiguration extends Exception
{
    /**
     * @return static
     */
    public static function configurationNotSet()
    {
        return new static('In order to send notification via Clicksend you need to add credentials in the `clicksend` key of `config.services`.');
    }
}
