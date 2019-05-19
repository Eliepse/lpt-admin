<?php

namespace App\Http\Controllers;

use App\Family;
use App\Http\Requests\StoreUserController;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class FamilyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('family.create');
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param StoreUserController $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUserController $request)
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
     * @return \Illuminate\Http\Response
     */
    public function show(Family $family)
    {
        return view('family.show', compact('family'));
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Family $family
     * @return \Illuminate\Http\Response
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
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Family $family)
    {
        //
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Family $family
     * @return \Illuminate\Http\Response
     */
    public function destroy(Family $family)
    {
        //
    }
}