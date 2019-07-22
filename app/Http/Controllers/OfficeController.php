<?php

namespace App\Http\Controllers;

use App\Office;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class OfficeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return Response
     */
    public function store(Request $request)
    {
        //
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
        $office->loadMissing(["schedules", "schedules.office", "schedules.classroom", "schedules.teachers"]);

        $schedules = $office->activeSchedules->groupBy("day");

        return view('models.office.show', compact('office', 'schedules'));
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param Office $office
     *
     * @return Response
     */
    public function edit(Office $office)
    {
        //
    }


    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param Office $office
     *
     * @return Response
     */
    public function update(Request $request, Office $office)
    {
        //
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param Office $office
     *
     * @return Response
     */
    public function destroy(Office $office)
    {
        //
    }
}
