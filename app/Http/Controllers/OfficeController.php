<?php

namespace App\Http\Controllers;

use App\Office;
use Illuminate\Http\Response;

class OfficeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('roles:admin,manager');
        $this->authorizeResource(Office::class, 'office');
    }


    /**
     * Display the specified resource.
     *
     * @param Office $office
     *
     * @return Response
     */
    public function show(Office $office)
    {
        $schedules = $office->activeSchedules
            ->sortBy('hour')
            ->groupBy("day");

        return view('models.office.show', compact('office', 'schedules'));
    }
}
