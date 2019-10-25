<?php

/**
 * This file contains usefull functions.
 * Requirement: only pure functions (see functional programming)
 */

if (!function_exists("bound")) {
    /**
     * Return the given value, inside the given range.
     *
     * @param int|float $value
     * @param int|float $min
     * @param int|float $max
     *
     * @return int|float The given value or the corresponding limit
     */
    function bound($value, $min, $max)
    {
        return min($max, max($min, $value));
    }
}
