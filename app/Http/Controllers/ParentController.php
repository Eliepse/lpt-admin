<?php

namespace App\Http\Controllers;

use App\Family;
use App\Http\Requests\StoreParentRequest;
use App\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class ParentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('roles:admin,manager');
        $this->authorizeResource(User::class, 'parent');
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::query()->where('type', 'client')->get();

        return view('users.index-parent', compact('users'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @param Family|null $family
     * @return \Illuminate\Http\Response
     */
    public function create(Family $family)
    {
        return view('parents.create', compact('family'));
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param StoreParentRequest $request
     * @param Family|null $family
     * @return \Illuminate\Http\Response
     */
    public function store(StoreParentRequest $request, Family $family)
    {
        $parent = new User($request->all());
        $parent->password = Hash::make(Str::random(24));
        $parent->type = 'client';
        $parent->family()->associate($family);
        $parent->save();

        return redirect(route('parents.index'));
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\User $parent
     * @return void
     */
    public function show(User $parent)
    {
        //
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\User $parent
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(User $parent)
    {
        return view('parents.edit', compact('parent'));
    }


    /**
     * Update the specified resource in storage.
     *
     * @param StoreParentRequest $request
     * @param  \App\User $parent
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(StoreParentRequest $request, User $parent)
    {
        $parent->fill($request->all());
        $parent->save();

        return redirect(route('family.show', $parent->family));
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User $parent
     * @return void
     */
    public function destroy(User $parent)
    {
        //
    }
}
