<?php

namespace App\Http\Controllers;

use App\Enums\Days;
use App\Grade;
use App\Http\Requests\StoreGradeRequest;
use Illuminate\Http\Request;

class GradeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('type:admin,teacher');
        $this->authorizeResource(Grade::class, 'grade');
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('grades.index');
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('grades.create');
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param StoreGradeRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreGradeRequest $request)
    {
        $grade = new Grade($request->all());
        $grade->timetable_days = [$request->get('timetable_day')];
        $grade->teacher()->associate($request->get('teacher'));
        $grade->save();

        $grade->courses()->attach($request->get("courses"));

        return redirect(route('courses.index'));
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Grade $grade
     * @return \Illuminate\Http\Response
     */
    public function show(Grade $grade)
    {
        //
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Grade $grade
     * @return \Illuminate\Http\Response
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
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Grade $grade)
    {
        //
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Grade $grade
     * @return \Illuminate\Http\Response
     */
    public function destroy(Grade $grade)
    {
        //
    }
}
