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
        $grade->teacher()->associate($request->get('teacher'));
        $grade->save();

        $grade->courses()->attach($request->get("courses"));

        return redirect(route('grades.index'));
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
     * @return void
     */
    public function edit(Grade $grade)
    {
        //
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Grade $grade
     * @return void
     */
    public function update(Request $request, Grade $grade)
    {
        //
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
    public function linkStudent(Grade $grade, Student $student)
    {
        $this->authorize('update', $grade);

        if ($grade->students()->find($student->id))
            return redirect()->back();

        $grade->students()->attach($student->id);

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
