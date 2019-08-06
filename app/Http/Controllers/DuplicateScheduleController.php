<?php


namespace App\Http\Controllers;

use App\Schedule;
use App\Sets\DaysSet;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\View\Factory;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class DuplicateScheduleController extends Controller
{
    use AuthorizesRequests, ValidatesRequests;


    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('roles:admin,manager');
    }


    /**
     * @param Schedule $schedule
     *
     * @return Factory|View
     * @throws AuthorizationException
     */
    public function form(Schedule $schedule)
    {
        $this->authorize('create', Schedule::class);

        return view('models.schedule.duplicate', compact('schedule'));
    }


    /**
     * @param Request $request
     * @param Schedule $schedule
     *
     * @return RedirectResponse
     * @throws AuthorizationException
     * @throws ValidationException
     */
    public function store(Request $request, Schedule $schedule)
    {
        $this->authorize('create', Schedule::class);

        $this->validate($request, [
            'hour' => 'required|date_format:H:i',
            'day' => 'required|in:' . join(',', DaysSet::getKeys()),
        ]);

        $new = $schedule->replicate(['students_count']);
        $new->hour = $request->get('hour');
        $new->day = $request->get('day');
        $new->save();

        return redirect()->route('schedule.promptDuplicate', $schedule);
    }


    /**
     * @param Schedule $schedule
     *
     * @return Factory|View
     * @throws AuthorizationException
     */
    public function prompt(Schedule $schedule)
    {
        $this->authorize('create', Schedule::class);

        return view('models.schedule.propose-duplicate', compact('schedule'));
    }
}
