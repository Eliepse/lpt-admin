<?php

namespace App\Http\Controllers;

use App\ClientUser;
use App\Family;
use App\Http\Requests\StoreParentRequest;
use App\Http\Requests\UpdateParentRequest;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\View\Factory;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\View\View;

class ParentController extends Controller
{
    use AuthorizesRequests;


    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('roles:admin,manager');
    }


    /**
     * Show the form for creating a new resource.
     *
     * @param Family|null $family
     *
     * @return Response
     * @throws AuthorizationException
     */
    public function create(Family $family)
    {
        $this->authorize('update', Family::class);

        return view('models.clientUser.create', compact('family'));
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param StoreParentRequest $request
     * @param Family $family
     *
     * @return Response
     * @throws AuthorizationException
     */
    public function store(StoreParentRequest $request, Family $family)
    {
        $this->authorize('update', Family::class);

        $parent = new ClientUser($request->all());
        $parent->password = Hash::make(Str::random(64));

        $family->parents()->save($parent);

        return redirect(route('families.show', $family));
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param ClientUser $parent
     *
     * @return Factory|View
     */
    public function edit(ClientUser $parent)
    {
        return view('models.clientUser.edit', compact('parent'));
    }


    /**
     * Update the specified resource in storage.
     *
     * @param UpdateParentRequest $request
     * @param ClientUser $parent
     *
     * @return RedirectResponse|Redirector
     */
    public function update(UpdateParentRequest $request, ClientUser $parent)
    {
        $parent->fill($request->all());
        $parent->save();

        return redirect(route('families.show', $parent->family));
    }
}
