<?php


namespace Eliepse\Alert;


class AlertError extends Alert
{
    public function __construct(string $message)
    {
        parent::__construct($message, self::ALERT_ERROR);
    }
}