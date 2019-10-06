<?php


namespace App\Sets;


use Eliepse\Set\Set;

class UserRolesSet extends Set
{
    public const ADMIN = 'admin';
    public const MANAGER = 'manager';
    public const TEACHER = 'teacher';

    protected static $nullable = true;
}
