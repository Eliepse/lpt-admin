<?php

namespace App\Http\Controllers;

use App\Classroom;
use App\Grade;
use App\Http\Requests\StoreClassroomRequest;
use App\Student;
use Illuminate\Http\Request;

class ClassroomController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('roles:admin,manager');
        $this->authorizeResource(Classroom::class, 'classroom');
    }


    /**
     * Display a listing of the resource.
     *
     * @param Grade|null $grade
     * @return void
     */
    public function index(Grade $grade = null)
    {
        //
    }


    /**
     * Show the form for creating a new resource.
     *
     * @param Grade $grade
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function create(Grade $grade)
    {
        $this->authorize('create', $grade);

        return view('models.classroom.create', compact('grade'));
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param StoreClassroomRequest $request
     * @param Grade $grade
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function store(StoreClassroomRequest $request, Grade $grade)
    {
        $this->authorize('create', $grade);

        $classroom = new Classroom($request->all());
        $classroom->timetables = json_decode($request->get('timetables'), true);

        $grade->classrooms()->save($classroom);

        return redirect(route('grades.show', $grade));
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Classroom $classroom
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(Classroom $classroom)
    {
        $grade = $classroom->grades()->first(['id', 'title']);

        return view('models.classroom.show', compact('classroom', 'grade'));
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Classroom $classroom
     * @return void
     */
    public function edit(Classroom $classroom)
    {
        //
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Classroom $classroom
     * @return void
     */
    public function update(Request $request, Classroom $classroom)
    {
        //
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Classroom $classroom
     * @return void
     */
    public function destroy(Classroom $classroom)
    {
        //
    }


    /**
     * @param Classroom $classroom
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function selectStudent(Classroom $classroom)
    {
        $this->authorize('update', $classroom);

        $students = Student::query()
            ->whereNotIn('id', $classroom->students->pluck('id'))
            ->get(['id', 'firstname', 'lastname', 'birthday']);

        return view('models.classroom.select-student', compact('classroom', 'students'));
    }


    /**
     * @param Classroom $classroom
     * @param Student $student
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function linkStudentForm(Classroom $classroom, Student $student)
    {
        $this->authorize('update', $classroom);

        $grade = $classroom->grades()->first(['id', 'title', 'price']);
        $student = $classroom->students()->where('id', $student->id)->first() ?: $student;

        return view('models.classroom.link-student', compact('classroom', 'student', 'grade'));
    }


    /**
     * @param Request $request
     * @param Classroom $classroom
     * @param Student $student
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \Illuminate\Auth\Access\AuthorizationException
     * @throws \Illuminate\Validation\ValidationException
     */
    public function linkStudent(Request $request, Classroom $classroom, Student $student)
    {
        $this->authorize('update', $classroom);

        $this->validate($request, [
            'price' => 'required|integer|between:-32500,32500',
            'paid' => 'required|integer|between:-32500,32500',
        ]);

        if ($classroom->students()->where('id', $student->id)->exists()) {
            $classroom->students()->updateExistingPivot($student->id, $request->all(['price', 'paid']));
        } else {
            $classroom->students()->attach($student->id, $request->all(['price', 'paid']));
        }


        return redirect(route('classrooms.show', $classroom));
    }


    /**
     * @param Request $request
     * @param Classroom $classroom
     * @param Student $student
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function unlinkStudent(Request $request, Classroom $classroom, Student $student)
    {
        $this->authorize('update', $classroom);

        $classroom->students()->detach($student->id);

        return redirect(route('classrooms.show', $classroom));
    }
}
