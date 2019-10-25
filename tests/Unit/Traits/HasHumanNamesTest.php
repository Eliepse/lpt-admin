<?php

namespace Tests\Unit\Traits;

use App\ClientUser;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class HasHumanNamesTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function fullname()
    {
        /** @var ClientUser $user */
        $user = factory(ClientUser::class)->make([
            'firstname' => 'john',
            'lastname' => 'doe',
            'firstname_zh' => null,
            'lastname_zh' => null,
        ]);

        $this->assertEquals('john doe', $user->getFullname());
        $this->assertEquals('doe john', $user->getFullname(true));
    }

    /**
     * @test
     */
    public function fullname_zh_with_chinese_value()
    {
        /** @var ClientUser $user */
        $user = factory(ClientUser::class)->make([
            'firstname' => 'john',
            'lastname' => 'doe',
            'firstname_zh' => '艾力',
            'lastname_zh' => '柴',
        ]);

        $this->assertEquals('艾力 柴', $user->getFullnameZh());
        $this->assertEquals('柴 艾力', $user->getFullnameZh(true));
    }

    /**
     * @test
     */
    public function fullname_zh_without_chinese_value()
    {
        /** @var ClientUser $user */
        $user = factory(ClientUser::class)->make([
            'firstname' => 'john',
            'lastname' => 'doe',
            'firstname_zh' => null,
            'lastname_zh' => null,
        ]);

        $this->assertEquals('john doe', $user->getFullnameZh());
        $this->assertEquals('doe john', $user->getFullnameZh(true));

        $user->firstname_zh = '';
        $user->lastname_zh = '';

        $this->assertEquals('john doe', $user->getFullnameZh());
    }

    /**
     * @test
     */
    public function has_chinese_names()
    {
        /** @var ClientUser $user */
        $user = factory(ClientUser::class)->make([
            'firstname' => 'john',
            'lastname' => 'doe',
            'firstname_zh' => null,
            'lastname_zh' => null,
        ]);

        $this->assertNull($user->firstname_zh);
        $this->assertNull($user->lastname_zh);
        $this->assertFalse($user->hasChineseNames());

        $user->firstname_zh = '艾力';

        $this->assertTrue($user->hasChineseNames());
    }
}
