<?php


namespace Eliepse\Alert;


class AlertSuccess extends Alert
{
    public function __construct(string $message, bool $dismissible = true)
    {
        parent::__construct($message, self::ALERT_SUCCESS, $dismissible);
    }
}
