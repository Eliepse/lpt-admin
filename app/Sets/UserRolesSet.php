<?php


namespace App\Sets;


use Eliepse\Set\Set;

class UserRolesSet extends Set
{
    public const ADMIN = 'admin';
    public const MANAGER = 'manager';
    public const TEACHER = 'teacher';

    protected static $nullable = true;


    /**
     * Test if two UserRolesSet have the same values
     * @param UserRolesSet $set
     *
     * @return bool
     */
    public function equals(UserRolesSet $set): bool
    {
        return $this->getValues() === $set->getValues();
    }
}
