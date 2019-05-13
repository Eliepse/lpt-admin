<?php

namespace Tests\Unit;

use App\Grade;
use App\Student;
use App\User;
use Illuminate\Database\Eloquent\Collection;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class GradeTest extends TestCase
{
    use RefreshDatabase;


    public function testCreateGrades()
    {
        $grade = factory(Grade::class)->create();

        $this->assertDatabaseHas('grades', ['id' => $grade->id]);
    }


    public function testTeacherRelation()
    {
        /** @var Grade $grade */
        $grade = factory(Grade::class)->create();
        /** @var Collection $students */
        $teacher = factory(User::class)->create(['type' => 'teacher']);

        $grade->teacher()->associate($teacher);

        $this->assertEquals($teacher->id, $grade->teacher()->first()->id);
    }


    public function testStudentsRelation()
    {
        /** @var Grade $grade */
        $grade = factory(Grade::class)->create();
        /** @var Collection $students */
        $students = factory(Student::class, 3)->create();

        $grade->students()->sync($students);

        $this->assertEquals(3, $grade->students()->count());
    }
}
