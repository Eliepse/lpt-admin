<?php

namespace Tests\Unit;

use App\Sets\UserRolesSet;
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
        $this->assertEquals(['admin', 'manager', 'teacher'], UserRolesSet::getMembers());
    }


    /**
     * @throws \Eliepse\Set\Exceptions\UnknownMemberException
     */
    public function testInitialize()
    {
        $set = new UserRolesSet(['manager', 'teacher']);
        $this->assertEquals(['manager', 'teacher'], $set->getValues());
    }


    /**
     * @throws \Eliepse\Set\Exceptions\UnknownMemberException
     */
    public function testHasValues()
    {
        $set = new UserRolesSet(['manager', 'teacher']);
        $this->assertTrue($set->has('teacher'));
        $this->assertTrue($set->has('manager'));
        $this->assertTrue($set->hasOne(['unvalid_member', 'admin', 'teacher']));
        $this->assertTrue($set->hasAll(['manager', 'teacher']));

        $this->assertFalse($set->hasOne(['unvalid_member', 'admin']));
        $this->assertFalse($set->hasAll(['unvalid_member', 'manager', 'teacher']));
        $this->assertFalse($set->has('admin'));
    }


    /**
     * @throws \Eliepse\Set\Exceptions\UnknownMemberException
     */
    public function testSetValues()
    {
        $set = new UserRolesSet();
        $set->set('teacher');
        $this->assertTrue($set->has('teacher'));
        $set->set(['admin']);
        $this->assertTrue($set->has('admin'));
        $this->assertTrue($set->has('teacher'));
    }
}
