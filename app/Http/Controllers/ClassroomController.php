<?php

namespace App\Http\Controllers;

use App\Classroom;
use App\Http\Requests\StoreClassroomRequest;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\View\Factory;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Routing\Redirector;
use Illuminate\View\View;

class ClassroomController extends Controller
{
    use AuthorizesRequests, ValidatesRequests;


    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('roles:admin,manager');
        $this->authorizeResource(Classroom::class, 'classroom');
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return Factory|View
     * @throws AuthorizationException
     */
    public function create()
    {
        $this->authorize('create', Classroom::class);

        return view('models.classroom.create');
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param StoreClassroomRequest $request
     *
     * @return RedirectResponse|Redirector
     * @throws AuthorizationException
     */
    public function store(StoreClassroomRequest $request)
    {
        $this->authorize('create', Classroom::class);

        $classroom = new Classroom($request->all(['name']));
        $classroom->save();

        $classroom->lessons()->sync(
            $this->prepareLessonsToSync($request->get('lessons', []))
        );

        if ($request->ajax())
            return response()->json(['redirect' => route('classrooms.show', $classroom)]);

        return redirect(route('classrooms.show', $classroom));
    }


    /**
     * Display the specified resource.
     *
     * @param Request $request
     * @param Classroom $classroom
     *
     * @return Factory|View
     */
    public function show(Request $request, Classroom $classroom)
    {
        $classroom->loadMissing(['schedules.teachers:id,firstname,lastname', "schedules.office"]);

        if ($request->ajax())
            return response()->json($classroom);

        return view('models.classroom.show', compact('classroom'));
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param Classroom $classroom
     *
     * @return Factory|View
     */
    public function edit(Classroom $classroom)
    {
        return view('models.classroom.edit', compact('classroom'));
    }


    /**
     * Update the specified resource in storage.
     *
     * @param StoreClassroomRequest $request
     * @param Classroom $classroom
     *
     * @return RedirectResponse|Redirector
     * @throws AuthorizationException
     */
    public function update(StoreClassroomRequest $request, Classroom $classroom)
    {
        $this->authorize('update', $classroom);

        $classroom->fill($request->all(['name']));
        $classroom->save();

        $classroom->lessons()->sync(
            $this->prepareLessonsToSync($request->get('lessons', []))
        );

        if ($request->ajax())
            return response()->json(['redirect' => route('classrooms.show', $classroom)]);

        return redirect(route('classrooms.show', $classroom));
    }


    /**
     * Prepare lessons from the requests to match the sync method's requirements
     *
     * @param array $lessons The lesson array from the request
     *
     * @return array
     */
    private function prepareLessonsToSync(array $lessons)
    {
        $result = [];

        foreach ($lessons as $el) {
            $result[ $el['id'] ] = [
                'duration' => $el['duration'],
            ];
        }

        return $result;
    }
}
