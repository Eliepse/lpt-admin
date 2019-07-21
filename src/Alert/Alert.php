<?php


namespace Eliepse\Alert;


use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\Jsonable;

class Alert implements Jsonable, Arrayable
{
    public const ALERT_SUCCESS = 'success';
    public const ALERT_ERROR = 'error';
    public const ALERT_INFO = 'info';

    /**
     * @var string
     */
    public $message;

    /**
     * @var int
     */
    public $type;


    public function __construct(string $message, string $type = self::ALERT_INFO)
    {
        $this->message = $message;
        $this->type = $type;
    }


    /**
     * @return string
     */
    public function getMessage(): string
    {
        return $this->message;
    }


    /**
     * @param string $message
     */
    public function setMessage(string $message): void
    {
        $this->message = $message;
    }


    /**
     * @return int
     */
    public function getType(): int
    {
        return $this->type;
    }


    /**
     * @param int $type
     */
    public function setType(int $type): void
    {
        $this->type = $type;
    }


    /**
     * Get the instance as an array.
     *
     * @return array
     */
    public function toArray()
    {
        return [
            "type" => $this->type,
            "message" => $this->message,
        ];
    }


    /**
     * Convert the object to its JSON representation.
     *
     * @param int $options
     *
     * @return string
     */
    public function toJson($options = 0)
    {
        return json_encode($this->toArray(), $options);
    }


}