<?php

namespace Tests;

use App\Sets\UserRolesSet;
use App\StaffUser;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;


    protected function createAdmin($attributes = []): StaffUser
    {
        return factory(StaffUser::class)
            ->create(array_merge(['roles' => new UserRolesSet([UserRolesSet::ADMIN])], $attributes));
    }

}
