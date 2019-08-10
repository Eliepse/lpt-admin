<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\StaffUser;
use App\User;
use Illuminate\Contracts\Auth\StatefulGuard;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class ResetPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords;

    /**
     * @var User
     */
    protected $userToReset;


    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }


    /**
     * @return StatefulGuard
     */
    public function guard()
    {
        return $this->isStaffUser() ? Auth::guard('admin') : Auth::guard();
    }


    public function redirectPath()
    {
        return $this->isStaffUser() ? route('dashboard') : route('home');
    }


    public function isStaffUser()
    {
        // A boolean is used when the user does not exists, in case this method is called before
        // email validation has been made
        if (empty($this->userToReset) && !is_bool($this->userToReset))
            $this->userToReset = User::query()->where('email', request('email'))->first() ?? false;

        return is_bool($this->userToReset) ? $this->userToReset : $this->userToReset->isStaff();
    }


    protected function rules()
    {
        return [
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|confirmed|' . ($this->isStaffUser() ? 'min:12' : 'min:8'),
        ];
    }


}
