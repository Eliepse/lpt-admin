<?php

namespace Tests\Unit;

use App\Sets\UserRoles;
use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\WithoutEvents;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserRolesSetTest extends TestCase
{
    use WithoutEvents;
    use WithoutMiddleware;


    /**
     * @return void
     * @throws \Eliepse\Set\Exceptions\UnknownMemberException
     */
    public function testMembers()
    {
        $this->assertEquals(['admin', 'manager', 'teacher'], UserRoles::getMembers());
    }


    /**
     * @throws \Eliepse\Set\Exceptions\UnknownMemberException
     */
    public function testInitialize()
    {
        $set = new UserRoles(['manager', 'teacher']);
        $this->assertEquals(['manager', 'teacher'], $set->getValues());
    }


    /**
     * @throws \Eliepse\Set\Exceptions\UnknownMemberException
     */
    public function testHasValues()
    {
        $set = new UserRoles(['manager', 'teacher']);
        $this->assertTrue($set->has('teacher'));
        $this->assertTrue($set->has('manager'));
        // Not implemented yet
//        $this->assertTrue($set->has(['teacher', 'manager']));
        $this->assertFalse($set->has('admin'));
    }


    /**
     * @throws \Eliepse\Set\Exceptions\UnknownMemberException
     */
    public function testSetValues()
    {
        $set = new UserRoles();
        $set->set('teacher');
        $this->assertTrue($set->has('teacher'));
        $set->set(['admin']);
        $this->assertTrue($set->has('admin'));
        $this->assertTrue($set->has('teacher'));
    }
}
