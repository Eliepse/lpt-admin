<?php


namespace Eliepse\Set;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\Jsonable;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Schema\ColumnDefinition;
use JsonSerializable;
use ReflectionClass;

abstract class Set implements SetInterface, Arrayable, JsonSerializable, Jsonable
{
    /**
     * The active members of the Set stored
     *
     * @var array
     */
    private $values = [];

    /**
     * Is the Set nullable
     *
     * @var bool
     */
    protected static $nullable = false;


    /**
     * Set constructor.
     *
     * @param array|string $values
     */
    public function __construct($values = [])
    {
        $this->values = array_fill_keys(static::getKeys(), false);
        $this->set($values);
    }


    static private function getReflection(): ReflectionClass
    {
        return new ReflectionClass(static::class);
    }


    /**
     * Get members of the Set
     *
     * @return array
     */
    public static function getKeys(): array
    {
        return array_values(self::getReflection()->getConstants());
    }


    /**
     * Is the Set nullable
     *
     * @return bool
     */
    public static function isNullbale(): bool
    {
        return static::$nullable;
    }


    /**
     * Get active members of the Set
     *
     * @return array|null
     */
    public function getValues(): ?array
    {
        if (static::isNullbale() && array_filter($this->values) === []) {
            return null;
        }

        return array_keys(array_filter($this->values));
    }


    /**
     * Check if a single member is active
     *
     * @param string $key
     *
     * @return bool
     */
    public function has(string $key): bool
    {
        return in_array($key, $this->getValues(), true);
    }


    /**
     * Check if at least one of the given members is active
     *
     * @param array $keys
     *
     * @return bool
     */
    public function hasOne(array $keys): bool
    {
        if (array_intersect($this->getValues(), $keys) !== []) {
            return true;
        }

        return false;
    }


    /**
     * Check if every given members are active
     *
     * @param array $keys
     *
     * @return bool
     */
    public function hasStrict(array $keys): bool
    {
        if (count($keys) !== count($this->getValues())) {
            return false;
        }

        if (array_diff($this->getValues(), $keys) !== []) {
            return false;
        }

        return true;
    }


    /**
     * To set (or activate) a member of the Set
     *
     * @param array|string $keys
     *
     * @return void
     */
    public function set($keys): void
    {
        if (is_string($keys) && static::hasKey($keys)) {
            $this->values[ $keys ] = true;
        }

        if (is_array($keys)) {
            foreach (array_intersect(static::getKeys(), $keys) as $key) {
                $this->values[ $key ] = true;
            }
        }
    }


    /**
     * To unset (or unactivate) a member of the Set
     *
     * @param string|array $keys
     *
     * @return void
     */
    public function unset($keys): void
    {
        if (is_string($keys) && static::hasKey($keys)) {
            $this->values[ $keys ] = false;
        }

        if (is_array($keys)) {
            foreach (array_intersect(static::getKeys(), $keys) as $key) {
                $this->values[ $key ] = false;
            }
        }
    }


    /**
     * To unset all members of the Set
     *
     * @return void
     */
    public function reset(): void
    {
        $this->values = array_fill_keys(static::getKeys(), false);
    }


    /**
     * Check if the member exists
     *
     * @param string $key
     *
     * @return bool
     */
    public static function hasKey(string $key): bool
    {
        return in_array($key, static::getKeys(), true);
    }


    static public function validate(array $array): bool
    {
        foreach ($array as $key) {
            if (!self::hasKey($key)) {
                return false;
            }
        }

        return true;
    }


    /**
     * Handle the creation of the table for the Set
     *
     * @param Blueprint $table
     * @param string $column_name
     *
     * @return ColumnDefinition
     */
    public static function createTableColumn(Blueprint $table, string $column_name): ColumnDefinition
    {
        return $table->set($column_name, static::getKeys())->nullable(static::isNullbale());
    }


    public function __toString(): string
    {
        return join(',', $this->getValues());
    }


    /**
     * Get the instance as an array.
     *
     * @return array
     */
    public function toArray()
    {
        return $this->getValues();
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
        return json_encode($this->jsonSerialize(), $options);
    }


    /**
     * Specify data which should be serialized to JSON
     *
     * @link https://php.net/manual/en/jsonserializable.jsonserialize.php
     * @return array data which can be serialized by <b>json_encode</b>,
     * which is a value of any type other than a resource.
     * @since 5.4.0
     */
    public function jsonSerialize()
    {
        return $this->toArray();
    }
}
