<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreLessonRequest;
use App\Http\Requests\UpdateLessonRequest;
use App\Lesson;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\View\View;

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
     * @param Request $request
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $lessons = Lesson::query()
            ->select(['id', 'name', 'description', 'category'])->get();

        if ($request->ajax())
            return response()->json($lessons);

        return view('models.lesson.index', ['lessons' => $lessons]);
    }


    /**
     * @return Factory|View
     */
    public function create()
    {
        return view('models.lesson.create');
    }


    /**
     * @param StoreLessonRequest $request
     *
     * @return RedirectResponse
     */
    public function store(StoreLessonRequest $request)
    {
        $lesson = new Lesson($request->only(['name', 'description', 'category']));
        $lesson->save();

        return redirect()->route('lessons.index');
    }


    public function edit(Lesson $lesson)
    {
        return view('models.lesson.edit', ['lesson' => $lesson]);
    }


    public function update(UpdateLessonRequest $request, Lesson $lesson)
    {
        $lesson->fill($request->only(['name', 'description', 'category']));
        $lesson->save();

        return redirect()->route('lessons.index');
    }
}
