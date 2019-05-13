<?php

namespace Tests\Unit;

use App\Grade;
use App\Student;
use App\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\Concerns\InteractsWithExceptionHandling;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class StudentTest extends TestCase
{
    use RefreshDatabase;


    public function testCreateStudents()
    {
        $student = factory(Student::class)->create();

        $this->assertDatabaseHas('students', ['id' => $student->id]);
    }


    public function testParentsRelation()
    {
        /** @var Student $student */
        /** @var Collection $parents */
        $parents = factory(User::class, 2)->create();
        $student = factory(Student::class)->create();

        $student->parents()->attach($parents->first()->id, ['relation' => 'mother']);
        $student->parents()->attach($parents->last()->id, ['relation' => 'father']);

        $this->assertEquals(2, $student->parents()->count());
    }


    public function testParentMissingRelation()
    {
        /** @var Student $student */
        $parents = factory(User::class)->create();
        $student = factory(Student::class)->create();

        $this->expectException(\Illuminate\Database\QueryException::class);

        $student->parents()->attach($parents->pluck('id'));
    }


    public function testGradesRelation()
    {
        /** @var Student $student */
        $grades = factory(Grade::class, 3)->create();
        $student = factory(Student::class)->create();

        $student->grades()->attach($grades->pluck('id'));

        $this->assertEquals(3, $student->grades()->count());
    }
}
