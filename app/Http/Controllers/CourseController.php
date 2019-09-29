<?php

namespace App\Http\Controllers;

use App\Course;
use App\Http\Requests\StoreCourseRequest;
use Eliepse\Alert\Alert;
use Eliepse\Alert\AlertSuccess;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\View\Factory;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Arr;
use Illuminate\View\View;

class CourseController extends Controller
{
    use AuthorizesRequests, ValidatesRequests;


    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('roles:admin,manager');
        $this->authorizeResource(Course::class, 'course');
    }


    /**
     * @return View
     */
    public function index()
    {
        $courses = Course::all();

        return view("models.course.index", compact('courses'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return View
     * @throws AuthorizationException
     */
    public function create()
    {
        $this->authorize('create', Course::class);

        return view('models.course.create');
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param StoreCourseRequest $request
     *
     * @return RedirectResponse|Redirector
     * @throws AuthorizationException
     */
    public function store(StoreCourseRequest $request)
    {
        $this->authorize('create', Course::class);

        $course = new Course($request->only(['name', 'description']));
        $course->save();
        
        // Workaround to allow models duplicates
        foreach ($request->get('lessons', []) as $lesson) {
            $course->lessons()->attach($lesson['id'], Arr::only($lesson, ['duration']));
        }

        if ($request->ajax())
            return response()->json(['redirect' => route('courses.show', $course)]);

        return redirect()
            ->route('courses.show', $course)
            ->with('alerts', [
                new AlertSuccess('Le cours a été ajouté.'),
            ]);
    }


    /**
     * Display the specified resource.
     *
     * @param Request $request
     * @param Course $course
     *
     * @return View
     */
    public function show(Request $request, Course $course)
    {
        $course->loadMissing(['schedules.teachers:id,firstname,lastname', "schedules.campus"]);

        if ($request->ajax())
            return response()->json($course);

        return view('models.course.show', compact('course'));
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param Course $course
     *
     * @return View
     */
    public function edit(Course $course)
    {
        return view('models.course.edit', compact('course'));
    }


    /**
     * Update the specified resource in storage.
     *
     * @param StoreCourseRequest $request
     * @param Course $course
     *
     * @return RedirectResponse|Redirector
     * @throws AuthorizationException
     */
    public function update(StoreCourseRequest $request, Course $course)
    {
        $this->authorize('update', $course);

        $course->fill($request->only(['name', 'description']));
        $course->save();

        // We start from zero
        $course->lessons()->sync([]);

        // And then we add back all lessons
        // Workaround to allow models duplicates
        foreach ($request->get('lessons', []) as $lesson) {
            $course->lessons()->attach($lesson['id'], Arr::only($lesson, ['duration']));
        }

        if ($request->ajax())
            return response()->json(['redirect' => route('courses.show', $course)]);

        return redirect()
            ->route('courses.show', $course)
            ->with('alerts', [
                new AlertSuccess('Le cours a été modifié.'),
            ]);
    }


    /**
     * @param Course $course
     *
     * @return Factory|View
     * @throws AuthorizationException
     */
    public function delete(Course $course)
    {
        $this->authorize('delete', $course);

        return view('models.course.delete', ['course' => $course]);
    }


    /**
     * @param Course $course
     *
     * @return RedirectResponse
     * @throws AuthorizationException
     */
    public function destroy(Course $course)
    {
        $this->authorize('delete', $course);

        $course->delete();

        return redirect()
            ->route('courses.index')
            ->with(['alerts' => [new AlertSuccess('Le cours a été supprimé.')]]);
    }
}
