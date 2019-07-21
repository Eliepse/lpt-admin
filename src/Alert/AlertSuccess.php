<?php


namespace Eliepse\Alert;


class AlertSuccess extends Alert
{
    public function __construct(string $message)
    {
        parent::__construct($message, self::ALERT_SUCCESS);
    }
}