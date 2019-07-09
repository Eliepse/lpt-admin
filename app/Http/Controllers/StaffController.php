<?php


namespace App\Http\Controllers;


use App\StaffUser;
use Illuminate\Http\Request;

class StaffController
{
    public function index(Request $request)
    {
        $query = StaffUser::query()->select($request->get('fields', '*'));

        // TODO(eliepse): request validation
        if ($request->has('has_role'))
            $query->whereIn('roles', $request->get('has_role', []));

        $staff = $query->get();

        if ($request->ajax())
            return response()->json($staff);

        return response('');
    }
}