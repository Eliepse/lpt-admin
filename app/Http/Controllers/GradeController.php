<?php

namespace App\Http\Controllers;

use App\Enums\DaysEnum;
use App\Grade;
use App\Http\Requests\StoreGradeRequest;
use App\Lesson;
use App\Student;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class GradeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('roles:admin,manager');
        $this->authorizeResource(Grade::class, 'grade');
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $grades = Grade::with(['classrooms'])->get();

        return view('grades.index', compact('grades'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create(Request $request)
    {
        $grade = Grade::find($request->get('grade'));

        return view('grades.create', compact('grade'));
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

        if (!empty($request->get('teacher')))
            $grade->teacher()->associate($request->get('teacher'));

        $grade->save();

//        $grade->lessons()->attach($request->get("lessons"));

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
        return view('grades.show', compact('grade'));
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

        if (empty($request->get('teacher')))
            $grade->teacher()->dissociate();
        else
            $grade->teacher()->associate($request->get('teacher'));

        $grade->save();

//        $grade->lessons()->sync($request->get("lessons"));

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
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function selectLesson(Grade $grade)
    {
        $this->authorize('update', $grade);

        $lessons = Lesson::all();

        return view('grades.select-lesson', compact('grade', 'lessons'));
    }


    /**
     * @param Grade $grade
     * @param Lesson $lesson
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function linkLessonForm(Grade $grade, Lesson $lesson)
    {
        $this->authorize('update', $grade);

        $lesson = $grade->lessons()->find($lesson->id) ?: $lesson;

        return view('grades.link-lesson', compact('grade', 'lesson'));
    }


    /**
     * @param Request $request
     * @param Grade $grade
     * @param Lesson $lesson
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \Illuminate\Auth\Access\AuthorizationException
     * @throws \Illuminate\Validation\ValidationException
     */
    public function linkLesson(Request $request, Grade $grade, Lesson $lesson)
    {
        $this->authorize('update', $grade);

        $this->validate($request, [
            'duration' => 'required|integer|between:1,65000',
            'teacher_id' => 'sometimes|nullable|exists:users,id',
        ]);

        if ($grade->lessons()->find($lesson->id)) {
            $grade->lessons()
                ->updateExistingPivot($lesson->id, $request->all(['duration']));
        } else {
            $grade->lessons()
                ->withPivotValue($request->all(['duration']))
                ->attach($lesson->id);
        }

        return redirect(route('grades.show', $grade));
    }


    /**
     * @param Grade $grade
     * @param Lesson $lesson
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function unlinkLesson(Grade $grade, Lesson $lesson)
    {
        $this->authorize('update', $grade);

        $grade->lessons()->detach($lesson->id);

        return redirect(route('grades.show', $grade));
    }

}
