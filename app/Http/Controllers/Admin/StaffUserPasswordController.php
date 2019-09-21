<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\UpdateStaffUserPasswordRequest;
use App\StaffUser;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\View\Factory;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class StaffUserPasswordController
{
    use AuthorizesRequests;


    /**
     * @param StaffUser $staff
     *
     * @return Factory|View
     * @throws AuthorizationException
     */
    public function form(StaffUser $staff)
    {
        $this->authorize('updatePassword', $staff);

        return view('admin.staff.password', ['staff' => $staff]);
    }


    /**
     * @param UpdateStaffUserPasswordRequest $request
     * @param StaffUser $staff
     *
     * @return RedirectResponse
     * @throws AuthorizationException
     */
    public function update(UpdateStaffUserPasswordRequest $request, StaffUser $staff)
    {
        $this->authorize('updatePassword', $staff);

        $staff->password = Hash::make($request->get('password'));
        $staff->save();

        return redirect()->route('staff.index');
    }
}
