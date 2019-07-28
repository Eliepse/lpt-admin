<?php

namespace App\Http\Controllers;

use App\Lesson;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

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

        return response('', 403);
    }
}
