<?php

namespace Tests\Unit\Sets;

use App\Sets\UserRolesSet;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserRolesSetTest extends TestCase
{
    /**
     * @test
     */
    public function getKeys()
    {
        $this->assertEquals(['admin', 'manager', 'teacher'], UserRolesSet::getKeys());
    }


    /**
     * @test
     */
    public function correct_values_with_constructor()
    {
        $set = new UserRolesSet($roles = ['admin', 'teacher']);

        $this->assertEquals($roles, $set->getValues());
    }


    /**
     * @test
     */
    public function reset()
    {
        $set = new UserRolesSet($roles = ['admin', 'teacher']);
        $set->reset();

        $this->assertEquals(null, $set->getValues());
    }


    /**
     * @test
     */
    public function set()
    {
        $set = new UserRolesSet();

        $set->set('admin');
        $this->assertEquals(['admin'], $set->getValues());

        $set->set(['teacher']);
        $this->assertEquals(['admin', 'teacher'], $set->getValues());
    }


    /**
     * @test
     */
    public function unset()
    {
        $set = new UserRolesSet($roles = ['admin', 'manager', 'teacher']);

        $set->unset('admin');
        $this->assertEquals(['manager', 'teacher'], $set->getValues());

        $set->unset(['teacher']);
        $this->assertEquals(['manager'], $set->getValues());
    }


    /**
     * @test
     */
    public function hasKey()
    {
        $this->assertTrue(UserRolesSet::hasKey('admin'));
        $this->assertFalse(UserRolesSet::hasKey('blah'));
    }


    /**
     * @test
     */
    public function has()
    {
        $set = new UserRolesSet(['admin', 'teacher']);

        $this->assertTrue($set->has('admin'));
        $this->assertFalse($set->has('manager'));
    }


    /**
     * @test
     */
    public function hasOne()
    {
        $set = new UserRolesSet(['admin', 'teacher']);

        $this->assertTrue($set->hasOne(['admin']));
        $this->assertTrue($set->hasOne(['admin', 'manager']));
        $this->assertFalse($set->hasOne(['manager']));
    }


    /**
     * @test
     */
    public function hasStrict()
    {
        $set = new UserRolesSet(['admin', 'teacher']);

        $this->assertTrue($set->hasStrict(['admin', 'teacher']));
        $this->assertFalse($set->hasStrict(['admin']));
        $this->assertFalse($set->hasStrict(['manager']));
    }


    /**
     * @test
     */
    public function equals()
    {
        $set = new UserRolesSet(['admin', 'teacher']);

        $this->assertTrue($set->equals(new UserRolesSet(['admin', 'teacher'])));
        $this->assertFalse($set->equals(new UserRolesSet(['admin', 'manager'])));
        $this->assertFalse($set->equals(new UserRolesSet(['admin'])));
        $this->assertFalse($set->equals(new UserRolesSet()));
    }
}
