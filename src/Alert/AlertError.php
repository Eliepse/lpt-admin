<?php


namespace Eliepse\Alert;


class AlertError extends Alert
{
    public function __construct(string $message, bool $dismissible = true)
    {
        parent::__construct($message, self::ALERT_ERROR, $dismissible);
    }
}
