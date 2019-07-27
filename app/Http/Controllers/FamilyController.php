<?php

namespace App\Http\Controllers;

use App\ClientUser;
use App\Family;
use App\Http\Requests\StoreFamilyRequest;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\View\Factory;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Controller;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\View\View;

class FamilyController extends Controller
{
    use AuthorizesRequests;


    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('roles:admin,manager');
    }


    public function show(Family $family)
    {
        return view('models.family.show', compact('family'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return Factory|View
     * @throws AuthorizationException
     */
    public function create()
    {
        $this->authorize('create', Family::class);

        return view('models.family.create');
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param StoreFamilyRequest $request
     *
     * @return RedirectResponse|Redirector
     * @throws AuthorizationException
     */
    public function store(StoreFamilyRequest $request)
    {
        $this->authorize('create', Family::class);

        // Instead of rejecting the request when a family already exists
        // we simply link a new student to it.

        /** @var ClientUser $parent */
        $parent = ClientUser::query()->firstOrNew(
            ['email' => Arr::get($request->get('parent'), 'email'),],
            Arr::get($request->all('parent'), 'parent', []));

        if (!$parent->exists) {
            $family = new Family();
            $family->save();
            $parent->password = Hash::make(Str::random(64));
            $parent->family()->associate($family);
            $parent->save();

        } elseif (!$parent->family) {
            $family = new Family();
            $family->save();
            $parent->family()->associate($family);
            $parent->save();

        } else {
            $family = $parent->family;
        }

        $family->students()->create(Arr::get($request->all('student'), 'student', []));

        return redirect()->route('family.show', $parent->family);
    }
}
