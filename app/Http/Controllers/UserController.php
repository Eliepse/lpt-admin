<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('roles:admin,teacher');
        $this->authorizeResource(User::class, 'user');
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $users = User::query()->where('type', '!=', 'parent')->get();

        return view('users.index-staff', compact('users'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        return view('users.create-staff');
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param StoreUserRequest $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(StoreUserRequest $request)
    {
        $user = new User($request->all());
        $user->password = Hash::make(Str::random(24));
        $user->type = 'staff';
        $user->save();

        return redirect(route('users.index'));
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\User $user
     * @return void
     */
    public function show(User $user)
    {
        //
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\User $user
     * @return void
     */
    public function edit(User $user)
    {
        //
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\User $user
     * @return void
     */
    public function update(Request $request, User $user)
    {
        //
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User $user
     * @return void
     */
    public function destroy(User $user)
    {
        //
    }
}
