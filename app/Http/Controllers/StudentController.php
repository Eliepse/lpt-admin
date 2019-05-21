<?php

namespace App\Http\Controllers;

use App\Family;
use App\Http\Requests\StoreStudentRequest;
use App\Student;
use App\User;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('type:admin,teacher');
        $this->authorizeResource(Student::class, 'student');
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $students = Student::all();

        return view('students.index', compact('students'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @param Family $family
     * @return \Illuminate\Http\Response
     */
    public function create(Family $family)
    {
        return view('students.create', compact('family'));
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param StoreStudentRequest $request
     * @param Family $family
     * @return \Illuminate\Http\Response
     */
    public function store(StoreStudentRequest $request, Family $family)
    {
        $student = new Student($request->all());
        $student->family()->associate($family);
        $student->save();

        return redirect(route('family.show', $family));
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Student $student
     * @return \Illuminate\Http\Response
     */
    public function show(Student $student)
    {
        //
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Student $student
     * @return \Illuminate\Http\Response
     */
    public function edit(Student $student)
    {
        //
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Student $student
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Student $student)
    {
        //
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Student $student
     * @return \Illuminate\Http\Response
     */
    public function destroy(Student $student)
    {
        //
    }
}
