<?php

namespace App\Http\Controllers;

use App\Family;
use App\Http\Requests\StoreParentRequest;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class FamilyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return void
     */
    public function index()
    {
        //
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        return view('family.create');
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param StoreParentRequest $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(StoreParentRequest $request)
    {
        $parent = new User($request->all());
        $parent->password = Hash::make(Str::random(24));
        $parent->type = 'parent';
        $parent->family()->associate(Family::create());
        $parent->save();

        return redirect(route('family.show', $parent->family));
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Family $family
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(Family $family)
    {
        return view('family.show', compact('family'));
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Family $family
     * @return void
     */
    public function edit(Family $family)
    {
        //
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Family $family
     * @return void
     */
    public function update(Request $request, Family $family)
    {
        //
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Family $family
     * @return void
     */
    public function destroy(Family $family)
    {
        //
    }
}
