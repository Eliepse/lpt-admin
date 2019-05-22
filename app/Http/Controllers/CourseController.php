<?php

namespace App\Http\Controllers;

use App\Course;
use App\Http\Requests\StoreCourseRequest;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('type:admin,teacher');
        $this->authorizeResource(Course::class, 'course');
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('courses.index');
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('courses.create');
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param StoreCourseRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCourseRequest $request)
    {
        $course = new Course($request->all());
        $course->teacher()->associate($request->get('teacher'));
        $course->save();

        return redirect(route('courses.index'));
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Course $course
     * @return void
     */
    public function show(Course $course)
    {
        //
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Course $course
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(Course $course)
    {
        return view('courses.edit', compact('course'));
    }


    /**
     * Update the specified resource in storage.
     *
     * @param StoreCourseRequest $request
     * @param  \App\Course $course
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(StoreCourseRequest $request, Course $course)
    {
        $course->fill($request->all());
        $course->teacher()->associate($request->get('teacher'));
        $course->save();

        return redirect(route('courses.index'));
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Course $course
     * @return void
     */
    public function destroy(Course $course)
    {
        //
    }
}
