<?php

namespace App\Http\Controllers;

use App\Lesson;
use App\Http\Requests\StoreLessonRequest;
use Illuminate\Http\Request;

class LessonController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('roles:admin,manager');
        $this->authorizeResource(Lesson::class, 'lesson');
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('lessons.index');
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('lessons.create');
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param StoreLessonRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreLessonRequest $request)
    {
        $lesson = new Lesson($request->all());
        $lesson->save();

        return redirect(route('lessons.index'));
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Lesson $lesson
     * @return void
     */
    public function show(Lesson $lesson)
    {
        //
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Lesson $lesson
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(Lesson $lesson)
    {
        return view('lessons.edit', compact('lesson'));
    }


    /**
     * Update the specified resource in storage.
     *
     * @param StoreLessonRequest $request
     * @param  \App\Lesson $lesson
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(StoreLessonRequest $request, Lesson $lesson)
    {
        $lesson->fill($request->all());
        $lesson->save();

        return redirect(route('lessons.index'));
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Lesson $lesson
     * @return void
     */
    public function destroy(Lesson $lesson)
    {
        //
    }
}
