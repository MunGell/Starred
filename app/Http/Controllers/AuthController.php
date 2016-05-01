<?php

namespace Starred\Http\Controllers;

use Starred\User;
use Starred\Token;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class AuthController extends Controller
{
    /**
     * Create a new authentication controller instance.
     */
    public function __construct()
    {
        $this->middleware('guest', ['except' => 'getLogout']);
    }

    /**
     * Get a validator for an incoming registration request.
     * @todo: this function is not used?
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'id' => 'required|numeric|unique:users',
            'login' => 'required|max:255|unique:users',
            'avatar' => 'required|url',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param $userdata
     * @return User
     */
    protected function create($userdata)
    {
        $user = User::updateOrCreate(['id' => $userdata->id], [
            'login' => $userdata->nickname,
            'avatar' => $userdata->avatar,
        ]);

        Token::updateOrCreate(['id' => $userdata->id], [
            'token' => $userdata->token,
            'auth' => bcrypt($userdata->token),
        ]);

        return $user;
    }

    public function getLogin()
    {
        return Socialite::driver('github')->redirect();
    }

    public function getCallback()
    {
        $userdata = Socialite::driver('github')->user();
        $this->create($userdata);
        Auth::loginUsingId($userdata->id, true);

        return redirect('/sync');
    }
}
