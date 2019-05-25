<?php

namespace App\Http\Controllers;

use App\Enums\Days;
use App\Grade;
use App\Http\Requests\StoreGradeRequest;
use App\Student;
use Illuminate\Http\Request;

class GradeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('roles:admin,teacher');
        $this->authorizeResource(Grade::class, 'grade');
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('grades.index');
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        return view('grades.create');
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param StoreGradeRequest $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(StoreGradeRequest $request)
    {
        $grade = new Grade($request->all());
        $grade->timetable_days = [$request->get('timetable_day')];

        if (!empty($request->get('teacher')))
            $grade->teacher()->associate($request->get('teacher'));

        $grade->save();

        $grade->courses()->attach($request->get("courses"));

        return redirect(route('grades.show', $grade));
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Grade $grade
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(Grade $grade)
    {
        $new_students = Student::query()
            ->select(['id', 'firstname', 'lastname'])
            ->whereNotIn('id', $grade->students->pluck('id'))
            ->get();

        return view('grades.show', compact('grade', 'new_students'));
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Grade $grade
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(Grade $grade)
    {
        return view('grades.edit', compact('grade'));
    }


    /**
     * Update the specified resource in storage.
     *
     * @param StoreGradeRequest $request
     * @param  \App\Grade $grade
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(StoreGradeRequest $request, Grade $grade)
    {
        $grade->fill($request->all());
        $grade->timetable_days = [$request->get('timetable_day')];

        if (empty($request->get('teacher')))
            $grade->teacher()->dissociate();
        else
            $grade->teacher()->associate($request->get('teacher'));

//        dd($grade);

        $grade->save();

        $grade->courses()->sync($request->get("courses"));

        return redirect(route('grades.show', $grade));
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Grade $grade
     * @return void
     */
    public function destroy(Grade $grade)
    {
        //
    }


    /**
     * @param Grade $grade
     * @param Student $student
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function linkStudentForm(Grade $grade, Student $student)
    {
        $this->authorize('update', $grade);

        if ($s_student = $grade->students()->find($student->id)) {
            $student = $s_student;
        }

        return view('grades.link-student', compact('grade', 'student'));
    }


    /**
     * @param Request $request
     * @param Grade $grade
     * @param Student $student
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \Illuminate\Auth\Access\AuthorizationException
     * @throws \Illuminate\Validation\ValidationException
     */
    public function linkStudent(Request $request, Grade $grade, Student $student)
    {
        $this->authorize('update', $grade);

        $this->validate($request, [
            'price' => 'required|integer|between:0,65000',
            'paid' => 'required|integer|between:0,65000',
        ]);

        if ($grade->students()->find($student->id)) {
            $grade->students()
                ->updateExistingPivot($student->id, $request->all(['price', 'paid']));

        } else {
            $grade->students()
                ->withPivotValue($request->all(['price', 'paid']))
                ->attach($student->id);
        }

        return redirect(route('grades.show', $grade));
    }


    /**
     * @param Grade $grade
     * @param Student $student
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function unlinkStudent(Grade $grade, Student $student)
    {
        $this->authorize('update', $grade);

        $grade->students()->detach($student->id);

        return redirect(route('grades.show', $grade));
    }


}
