<?php

namespace Tests\Unit;

use App\Grade;
use App\Student;
use App\User;
use Illuminate\Database\Eloquent\Collection;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserTest extends TestCase
{
    use RefreshDatabase;


    public function createAdmin(array $attributes = []): User
    {
        return factory(User::class)->create(array_merge($attributes, ['type' => 'admin']));
    }


    public function createTeacher(array $attributes = []): User
    {
        return factory(User::class)->create(array_merge($attributes, ['type' => 'teacher']));
    }


    public function createParent(array $attributes = []): User
    {
        return factory(User::class)->create(array_merge($attributes, ['type' => 'client']));
    }


    public function testCreateUsers()
    {
        $admin = $this->createAdmin();
        $teacher = $this->createTeacher();
        $parent = $this->createParent();

        $this->assertDatabaseHas('users', ['id' => $admin->id]);
        $this->assertDatabaseHas('users', ['id' => $teacher->id]);
        $this->assertDatabaseHas('users', ['id' => $parent->id]);
    }


    public function testChildrenRelation()
    {
        /** @var Collection $children */
        $parent = $this->createParent();
        $children = factory(Student::class, 2)->create();
        $parent->children()->attach($children->pluck('id'), ['relation' => 'mother']);

        $this->assertEquals(2, $parent->children()->count());
    }


    public function testGradesRelation()
    {
        /** @var Grade $grade */
        $teacher = $this->createTeacher();
        $grade = factory(Grade::class)->create();

        $grade->teacher()->associate($teacher);
        $grade->save();

        $this->assertEquals(1, $teacher->grades()->count());
    }
}
