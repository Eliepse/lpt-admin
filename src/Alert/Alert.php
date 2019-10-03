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
    private $message;

    /**
     * @var int
     */
    private $type;

    /**
     * @var bool
     */
    private $dismissible;


    /**
     * Alert constructor.
     *
     * @param string $message
     * @param string $type
     * @param bool $dismissible
     */
    public function __construct(string $message, string $type = self::ALERT_INFO, bool $dismissible = true)
    {
        $this->message = $message;
        $this->type = $type;
        $this->dismissible = $dismissible;
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


    public function isDissmissible(): bool
    {
        return $this->dismissible;
    }


    public function setDismissible(bool $value)
    {
        $this->dismissible = $value;
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


    /**
     * Render the alter from the view template
     *
     * @return string
     */
    public function render(): string
    {
        return view($this->dismissible ? 'components.alert.dismissible' : 'components.alert.default', [
            'class' => $this->type,
            'message' => $this->message,
        ]);
    }


}
