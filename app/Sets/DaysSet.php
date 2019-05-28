<?php


namespace App\Sets;


use Eliepse\Set\Set;

class DaysSet extends Set
{
    public const MONDAY = 'monday';
    public const TUESDAY = 'tuesday';
    public const WEDNESDAY = 'wednesday';
    public const THURSDAY = 'thursday';
    public const FRIDAY = 'friday';
    public const SATURDAY = 'saturday';
    public const SUNDAY = 'sunday';


    protected static $members = [
        'monday',
        'tuesday',
        'wednesday',
        'thursday',
        'friday',
        'saturday',
        'sunday',
    ];

    protected static $nullable = true;


    public function __toString(): string
    {
        return join(',', $this->getValues());
    }
}