<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreOfficeRequest;
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


    public function index()
    {
        $officies = Office::all();

        return view("models.office.index", compact("officies"));
    }


    public function create()
    {
        return view("models.office.create");
    }


    public function store(StoreOfficeRequest $request)
    {
        $office = new Office($request->all(['name']));
        $office->save();

        return redirect()->route('offices.index');
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
