<?php

namespace App\Rules;

use Eliepse\Set\SetInterface;
use Illuminate\Contracts\Validation\Rule;

/**
 * Class SetRule
 * @package App\Rules
 * @property SetInterface $setClass
 */
class SetRule implements Rule
{
    private $setClass;


    /**
     * Create a new rule instance.
     *
     * @param string $setClass The name of the Set class
     */
    public function __construct(string $setClass)
    {
        $this->setClass = $setClass;

        if (!class_exists($this->setClass)) {
            throw new \InvalidArgumentException("Cannot validate against the set, the class {$this->setClass} doesn't exist.");
        }
    }


    /**
     * Determine if the validation rule passes.
     *
     * @param  string $attribute
     * @param  mixed $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        return $this->setClass::hasKey($value);
    }


    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The key you have entered is invalid.';
    }
}
