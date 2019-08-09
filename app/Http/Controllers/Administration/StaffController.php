<?php


namespace App\Http\Controllers\Administration;


use App\Enums\UserTypeEnum;
use App\Http\Requests\StoreStaffRequest;
use App\Sets\UserRolesSet;
use App\StaffUser;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class StaffController
{
    use AuthorizesRequests;


    public function index(Request $request)
    {
        $this->authorize('viewAny', StaffUser::class);
        // TODO(eliepse): request validation


        if ($request->expectsJson()) {
            $staff = StaffUser::query()
                ->select($request->get('fields', '*'))
                ->whereIn('roles', Arr::wrap($request->get('has_role', [])))
                ->get();

            return response()->json($staff);
        }

        $staff = StaffUser::all();

        return view('admin.staff.index', compact('staff'));
    }


    public function create()
    {
        $this->authorize('create', StaffUser::class);

        return view("admin.staff.create");
    }


    public function store(StoreStaffRequest $request)
    {
        $this->authorize('create', StaffUser::class);

        $member = new StaffUser($request->all());
        $member->password = Hash::make(Str::random(64));
        $member->roles = new UserRolesSet($request->get('roles', []));
        $member->type = 'staff';
        $member->save();

        return redirect()->route('staff.index');
    }
}
