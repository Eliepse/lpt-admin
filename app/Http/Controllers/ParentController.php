<?php

namespace App\Http\Controllers;

use App\Family;
use App\Http\Requests\StoreUserController;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class ParentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('type:admin,teacher');
        $this->authorizeResource(User::class, 'parent');
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::query()->where('type', 'parent')->get();

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
        return view('users.create-parent', compact('family'));
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param StoreUserController $request
     * @param Family|null $family
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUserController $request, Family $family)
    {
        $parent = new User($request->all());
        $parent->password = Hash::make(Str::random(24));
        $parent->type = 'parent';
        $parent->family()->associate($family);
        $parent->save();

        return redirect(route('parents.index'));
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\User $parent
     * @return \Illuminate\Http\Response
     */
    public function show(User $parent)
    {
        //
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\User $parent
     * @return \Illuminate\Http\Response
     */
    public function edit(User $parent)
    {
        //
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\User $parent
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $parent)
    {
        //
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User $parent
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $parent)
    {
        //
    }
}
