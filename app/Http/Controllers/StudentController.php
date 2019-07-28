<?php

namespace App\Http\Controllers;

use App\Family;
use App\Http\Requests\StoreStudentRequest;
use App\Http\Requests\UpdateStudentRequest;
use App\Student;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;
use Illuminate\View\View;

class StudentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('roles:admin,manager');
        $this->authorizeResource(Student::class, 'student');
    }


    /**
     * Show the form for creating a new resource.
     *
     * @param Family $family
     *
     * @return View
     */
    public function create(Family $family)
    {
        return view('models.student.create', compact('family'));
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param StoreStudentRequest $request
     * @param Family $family
     *
     * @return RedirectResponse|Redirector
     */
    public function store(StoreStudentRequest $request, Family $family)
    {
        $family->students()->create($request->all(['firstname', 'lastname', 'birthday', 'notes']));

        return redirect(route('family.show', $family));
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param Student $student
     *
     * @return Factory|View
     */
    public function edit(Student $student)
    {
        return view('models.student.edit', compact('student'));
    }


    /**
     * Update the specified resource in storage.
     *
     * @param UpdateStudentRequest $request
     * @param Student $student
     *
     * @return RedirectResponse|Redirector
     */
    public function update(UpdateStudentRequest $request, Student $student)
    {
        $student->fill($request->all());
        $student->save();

        return redirect(route('family.show', $student->family));
    }
}
