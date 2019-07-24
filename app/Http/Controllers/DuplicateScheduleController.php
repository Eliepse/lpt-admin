<?php


namespace App\Http\Controllers;


use App\Schedule;
use App\Sets\DaysSet;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;

class DuplicateScheduleController
{
    use ValidatesRequests;


    public function form(Schedule $schedule)
    {
        return view('models.schedule.duplicate', compact('schedule'));
    }


    public function store(Request $request, Schedule $schedule)
    {
        $this->validate($request, [
            'hour' => 'required|date_format:H:i',
            'day' => 'required|in:' . join(',', DaysSet::getKeys()),
        ]);

        $new = $schedule->replicate(['students_count']);
        $new->hour = $request->get('hour');
        $new->day = $request->get('day');
        $new->save();

        return redirect()->route('office.show', $schedule->office);
    }
}