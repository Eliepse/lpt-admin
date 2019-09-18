<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreOfficeRequest;
use App\Http\Requests\UpdateOfficeRequest;
use App\Office;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\View\View;

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


    /**
     * @param Office $office
     *
     * @return Factory|View
     */
    public function edit(Office $office)
    {
        return view("models.office.edit", ['office' => $office]);
    }


    /**
     * @param UpdateOfficeRequest $request
     * @param Office $office
     *
     * @return RedirectResponse
     */
    public function update(UpdateOfficeRequest $request, Office $office)
    {
        $office->fill($request->only(["name", "postal_address"]));
        $office->save();

        return redirect()->route('offices.show', $office);
    }
}
